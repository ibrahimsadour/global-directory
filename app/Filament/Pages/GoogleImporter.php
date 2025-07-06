<?php
namespace App\Filament\Pages;

use App\Models\Category;
use App\Models\Location;
use App\Models\Governorate;
use App\Services\GooglePlacesService;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\BusinessHour;
use Illuminate\Support\Facades\Http;
use App\helpers;
class GoogleImporter extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cloud-arrow-down';
    protected static string $view = 'filament.pages.google-importer';
    protected static ?string $navigationLabel = 'استيراد من Google Maps';
    protected static ?string $title = 'استيراد أنشطة من Google Maps';
    public ?int $category_id = null;
    public ?string $keyword = null;
    public ?int $radius = 5;
    public array $savedPlaces = [];
    public ?int $governorate_id = null;
    public ?int $location_id = null;
    public ?string $governorateName = null; // 🆕 لعرض اسم المحافظة
    public ?string $locationName = null;    // 🆕 لعرض اسم المدينة
    public ?string $categoryName = null;    // 🆕 لعرض اسم التصنيف
    public Collection $results;

    protected function normalizeTime(string $time): string
    {
        // استبدال الرموز العربية والاختصارات لتسهيل التحليل
        $replacements = [
            'ص' => 'AM',
            'م' => 'PM',
            'ص.' => 'AM',
            'م.' => 'PM',
            '–' => '-', // في حال ظهرت داخل الوقت
            '٫' => ':', // نقطة عربية
            ' ' => ' ', // مسافات خاصة
            ' ' => ' ', // مسافات نحيلة
        ];

        $normalized = strtr($time, $replacements);

        // تأكد أن الساعة تحتوي على AM أو PM
        if (!Str::contains($normalized, ['AM', 'PM'])) {
            // إذا لم يكن بها AM/PM نحاول تحديدها بناءً على الرقم (افتراضي قبل 12 ظهرًا AM)
            $hour = (int)trim(Str::before($normalized, ':'));
            $normalized .= $hour < 12 ? ' AM' : ' PM';
        }

        return trim($normalized);
    }

    public function mount()
    {
        $this->form->fill();
        $this->results = collect();
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('إعدادات البحث')
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('governorate_id')
                            ->label('المحافظة')
                            ->options(\App\Models\Governorate::pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set) {
                                $set('location_id', null);
                            }),

                        Select::make('location_id')
                            ->label('المدينة / المنطقة')
                            ->options(function (callable $get) {
                                $governorateId = $get('governorate_id');
                                if (!$governorateId) {
                                    return [];
                                }

                                return \App\Models\Location::where('governorate_id', $governorateId)
                                    ->pluck('area', 'id');
                            })
                            ->searchable()
                            ->required()
                            ->reactive()
                            ->visible(fn (callable $get) => filled($get('governorate_id')))
                            ->hint(fn (callable $get) => !$get('governorate_id') ? 'اختر المحافظة أولاً' : null),

                        // ✅ حقل الفئات (التصنيفات)
                        Select::make('category_id')
                            ->label('التصنيف')
                            ->options(function () {
                                $options = [];

                                // جلب الفئات الرئيسية مرتبة حسب الاسم
                                $parents = \App\Models\Category::with(['children' => function ($query) {
                                        $query->orderBy('name');
                                    }])
                                    ->whereNull('parent_id')
                                    ->orderBy('name')
                                    ->get();

                                foreach ($parents as $parent) {
                                    // أضف الفئة الرئيسية
                                    $options[$parent->id] = $parent->name;

                                    // أضف الفئات الفرعية مع بادئة مرئية
                                    foreach ($parent->children as $child) {
                                        $options[$child->id] = '⤶ ' . $child->name; // رمز جميل للتفرع

                                    }
                                }

                                return $options;
                            })
                            ->searchable()
                            ->preload()
                            ->required(),

                    ]),

                    TextInput::make('keyword')
                        ->label('الكلمة المفتاحية')
                        ->required(),

                ])
        ];
    }


    public function fetchFromGoogle(GooglePlacesService $google)
    {
        $location = Location::find($this->location_id);
        $governorate = \App\Models\Governorate::find($this->governorate_id); // 🆕 جلب اسم المحافظة
        $category = \App\Models\Category::find($this->category_id);         // 🆕 جلب اسم التصنيف

        if (!$location || !$location->latitude || !$location->longitude) {
            Notification::make()
                ->title('تعذر العثور على إحداثيات المنطقة')
                ->danger()
                ->send();
            return;
        }

        // 🆕 تخزين الأسماء لعرضها في واجهة Blade
        $this->locationName = $location->area ?? 'غير محددة';
        $this->governorateName = $governorate->name ?? 'غير محددة';
        $this->categoryName = $category->name ?? 'غير محددة';

        $this->results = $google->fetchFullPlacesDetails(
            $this->keyword,
            $location,
            $this->radius
        );

        Notification::make()
            ->title("تم جلب {$this->results->count()} نشاط")
            ->success()
            ->send();
    }

    // حفظ جميع النشاطات
    public function saveResults(GooglePlacesService $google)
    {
        if ($this->results->isEmpty()) {
            Notification::make()
                ->title('لا توجد نتائج لحفظها')
                ->warning()
                ->send();
            return;
        }

        // فلترة النشاطات الجديدة فقط (غير موجودة مسبقًا)
        $newPlaces = $this->results->filter(function ($place) {
            return !\App\Models\Business::where('place_id', $place['place_id'])->exists();
        });

        $duplicatesCount = $this->results->count() - $newPlaces->count();

        if ($newPlaces->isEmpty()) {
            Notification::make()
                ->title('كل النشاطات محفوظة مسبقًا')
                ->warning()
                ->send();
            return;
        }

        // حفظ النشاطات الجديدة فقط
        $saved = $google->storeBusinesses(
            $newPlaces,
            [
                'governorate_id' => $this->governorate_id,
                'location_id'    => $this->location_id,
                'category_id'    => $this->category_id,
                'keyword'        => $this->keyword ?? '',
            ]
        );



        // إشعار بعدد النشاطات الجديدة والمحذوفة
        $message = "✅ تم حفظ {$saved} نشاط جديد";
        if ($duplicatesCount > 0) {
            $message .= "، وتجاهل {$duplicatesCount} نشاط محفوظ مسبقًا";
        }

        Notification::make()
            ->title($message)
            ->success()
            ->send();
    }

    // حفظ كل نشاط بشكل منفصل
    public function saveSinglePlace(string $placeId)
    {
        $place = $this->results->firstWhere('place_id', $placeId);

        if (!$place || \App\Models\Business::where('place_id', $placeId)->exists()) {
            \Filament\Notifications\Notification::make()
                ->title('هذا النشاط محفوظ بالفعل أو غير موجود')
                ->warning()
                ->send();
            return;
        }

        // 🔤 توليد اسم اللينك
        $slugSource = $place['name'] ?? 'نشاط-بدون-اسم';

        $slug = preg_match('/[\p{Arabic}]/u', $slugSource)
            ? preg_replace('/\s+/', '-', trim(preg_replace('/[^\p{Arabic}\p{L}\p{N}\s]/u', '', $slugSource)))
            : Str::slug($slugSource);

        $originalSlug = $slug;
        $counter = 1;

        // ✅ تحقق من وجود slug مكرر وقم بإضافة رقم فقط عند الحاجة
        while (\App\Models\Business::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        // ✅ توليد وصف وسيو من دوال الهيلبر
        $name = $place['name'] ?? 'بدون اسم';
        $categoryId = $this->category_id;
        $governorateId = $this->governorate_id;
        $phone = $place['phone'] ?? null;

        $description = generateBusinessDescription($name, $categoryId, $governorateId, $phone);
        $seo = generateBusinessSeo($name, $categoryId, $governorateId);

        // ✅ إنشاء النشاط
        $business = \App\Models\Business::create([
            'name'              => $name,
            'slug'              => $slug,
            'address'           => $place['address'] ?? null,
            'phone'             => $phone,
            'email'             => null,
            'website'           => $place['website'] ?? null,
            'whatsapp'          => null,
            'description'       => $description,
            'latitude'          => $place['latitude'] ?? null,
            'longitude'         => $place['longitude'] ?? null,
            'place_id'          => $place['place_id'],
            'user_id'           => auth()->id(),
            'governorate_id'    => $governorateId,
            'location_id'       => $this->location_id,
            'category_id'       => $categoryId,
            'rating'            => $place['rating'] ?? null,
            'reviews_count'     => $place['reviews_count'] ?? null,
            'image'             => $place['photo_url'] ?? null,
            'gallery'           => null,
            'facebook'          => null,
            'instagram'         => null,
            'twitter'           => null,
            'linkedin'          => null,
            'youtube'           => null,
            'is_featured'       => false,
            'is_approved'       => true,
            'is_active'         => true,
        ]);

        // ✅ حفظ بيانات السيو في جدول seos المرتبط
        $business->seo()->create([
            'meta_title'       => $seo['meta_title'] ?? $name,
            'meta_description' => $seo['meta_description'] ?? $name,
            'meta_keywords'    => $seo['meta_keywords'] ?? $name,
        ]);

            // ✅ حفظ أوقات العمل إن وُجدت
            if (!empty($place['opening_hours']) && is_array($place['opening_hours'])) {
                foreach ($place['opening_hours'] as $entry) {
                    // مثال: "السبت: 7:00 ص – 11:00 م"
                    if (preg_match('/^(.+?):\s*(.+)$/u', $entry, $matches)) {
                        $day = trim($matches[1]);
                        $hours = trim($matches[2]);

                        try {
                            if (Str::contains($hours, ['Open 24 hours', 'نعمل على مدار 24 ساعة'])) {
                                // 🟢 دوام كامل
                                BusinessHour::create([
                                    'business_id' => $business->id,
                                    'day'         => $day,
                                    'open_time'   => '00:00:00',
                                    'close_time'  => '23:59:59',
                                ]);
                            } elseif (Str::contains($hours, ['–', '-'])) {
                                // 🕒 تنسيق وقت مفتوح
                                [$open, $close] = preg_split('/–|-/', $hours);

                                // ✅ تحويل الوقت العربي إلى إنجليزي لتفادي أخطاء parsing
                                $open = $this->normalizeTime(trim($open));
                                $close = $this->normalizeTime(trim($close));

                                BusinessHour::create([
                                    'business_id' => $business->id,
                                    'day'         => $day,
                                    'open_time'   => Carbon::parse($open)->format('H:i:s'),
                                    'close_time'  => Carbon::parse($close)->format('H:i:s'),
                                ]);
                            }
                        } catch (\Exception $e) {
                            Log::warning("فشل في حفظ وقت الدوام لـ {$day} في النشاط {$business->name}: {$hours}");
                        }
                    }
                }
            }

        $this->savedPlaces[] = $placeId;

        \Filament\Notifications\Notification::make()
            ->title('✅ تم حفظ النشاط بنجاح')
            ->success()
            ->send();
    }

}
