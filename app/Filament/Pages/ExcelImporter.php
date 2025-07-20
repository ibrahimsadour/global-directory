<?php

namespace App\Filament\Pages;

use App\Imports\ExcelBusinessesReader;
use App\Jobs\ImportBusinessRowJob;
use App\Models\Category;
use App\Models\Governorate;
use App\Models\Location;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ImportLog;
use Illuminate\Support\Facades\Cache;

class ExcelImporter extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-up';
    protected static string $view = 'filament.pages.excel-importer';
    protected static ?string $navigationLabel = 'استيراد Excel';
    protected static ?string $title = 'استيراد النشاطات من Excel';

    public ?int $governorate_id = null;
    public ?int $location_id = null;
    public ?int $category_id = null;
    public $excel_file;
    public ?string $governorateName = null;
    public ?string $locationName = null;
    public ?string $categoryName = null;
    public Collection $previewBusinesses;
    public array $savedPlaces = [];

    protected function getFormSchema(): array
    {
        return [
            Section::make('إعدادات الاستيراد')
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('governorate_id')
                            ->label('المحافظة')
                            ->options(Governorate::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($set) => $set('location_id', null)),

                        Select::make('location_id')
                            ->label('المدينة / المنطقة')
                            ->options(fn ($get) =>
                                $get('governorate_id')
                                    ? Location::where('governorate_id', $get('governorate_id'))->pluck('area', 'id')
                                    : []
                            )
                            ->searchable()
                            ->required()
                            ->visible(fn ($get) => filled($get('governorate_id')))
                            ->hint(fn ($get) => !$get('governorate_id') ? 'اختر المحافظة أولاً' : null),
                    ]),
                    Grid::make(1)->schema([
                        Select::make('category_id')
                            ->label('التصنيف')
                            ->options(function () {
                                $options = [];
                                $parents = Category::with('children')->whereNull('parent_id')->orderBy('name')->get();
                                foreach ($parents as $parent) {
                                    $options[$parent->id] = '📁 ' . $parent->name;
                                    foreach ($parent->children as $child) {
                                        $options[$child->id] = '⤶ ' . $child->name;
                                    }
                                }
                                return $options;
                            })
                            ->searchable()
                            ->required(),
                    ]),
                    FileUpload::make('excel_file')
                        ->label('ملف Excel')
                        ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                        ->disk('public')
                        ->directory('imported-excel')
                        ->required(),
                ])
        ];
    }

    public function mount(): void
    {
        $this->form->fill();
        $this->previewBusinesses = collect();
    }

    public function processImport()
    {
        $data = $this->form->getState();

        if (empty($data['excel_file'])) {
            Notification::make()
                ->title('⚠️ لم يتم رفع ملف Excel')
                ->danger()
                ->send();
            return;
        }

        Log::channel('import-businesses')->info("🧾 بدء الاستيراد بواسطة: " . Auth::user()?->name);

        $reader = new ExcelBusinessesReader();
        Excel::import($reader, $data['excel_file']);
        $businesses = $reader->getBusinesses();

        if (!$businesses || $businesses->isEmpty()) {
            Notification::make()
                ->title('⚠️ لم يتم العثور على بيانات صالحة في ملف Excel')
                ->danger()
                ->send();
            return;
        }

        $location = Location::findOrFail($this->location_id);
        $polygon = json_decode($location->polygon, true)['coordinates'] ?? null;

        if ($polygon) {
            $filtered = collect();

            foreach ($businesses as $row) {
                $lat = $row['latitude'] ?? null;
                $lng = $row['longitude'] ?? null;

                if (!$lat || !$lng) {
                    Log::channel('import-businesses')->warning("❌ النشاط '{$row['name']}' تم استبعاده: إحداثيات غير صالحة.");
                    continue;
                }

                if (!$this->pointInPolygon(floatval($lng), floatval($lat), $polygon)) {
                    Log::channel('import-businesses')->warning("❌ النشاط '{$row['name']}' خارج حدود المنطقة '{$location->area}'.", [
                        'lat' => $lat,
                        'lng' => $lng,
                    ]);
                    continue;
                }

                // 🔧 تنظيف رابط الصورة إن كانت من Google Photos
                if (!empty($row['image']) && str_starts_with($row['image'], 'https://lh3.googleusercontent.com')) {
                    $row['image'] = preg_replace('/=w.*$/', '', $row['image']);
                }

                $filtered->push($row);
            }

            $businesses = $filtered->values();
        }

        $this->previewBusinesses = $businesses;
        $this->governorateName = optional($location->governorate)->name;
        $this->locationName = $location->area;
        $this->categoryName = optional(Category::find($this->category_id))->name;

        $totalCount = $reader->getBusinesses()->count();
        $filteredCount = $businesses->count();
        $rejectedCount = $totalCount - $filteredCount;

        Notification::make()
            ->title('✅ تم تحليل الملف بنجاح')
            ->body("📊 تم تحليل الملف:\n✅ مقبول: {$filteredCount} نشاط\n❌ مرفوض: {$rejectedCount} نشاط\n📦 الإجمالي: {$totalCount}")
            ->success()
            ->send();
    }

    protected function pointInPolygon(float $lng, float $lat, array $polygon): bool
    {
        $inside = false;
        $points = $polygon[0]; // نستخدم أول مضلع فقط
        $j = count($points) - 1;

        for ($i = 0; $i < count($points); $i++) {
            $xi = $points[$i][0]; // lng
            $yi = $points[$i][1]; // lat
            $xj = $points[$j][0];
            $yj = $points[$j][1];

            $intersect = (($yi > $lat) != ($yj > $lat)) &&
                ($lng < ($xj - $xi) * ($lat - $yi) / (($yj - $yi) ?: 0.0000001) + $xi);

            if ($intersect) {
                $inside = !$inside;
            }

            $j = $i;
        }

        return $inside;
    }


    public function saveBusinesses()
    {
        if (!$this->previewBusinesses || $this->previewBusinesses->isEmpty()) {
            Notification::make()
                ->title('⚠️ لا توجد بيانات لحفظها.')
                ->danger()
                ->send();
            return;
        }

        // 🧹 إعادة تعيين عداد الحفظ للمستخدم الحالي
        $cacheKey = 'imported_count_user_' . auth()->id();
        Cache::forget($cacheKey);

        // 📦 إرسال كل نشاط إلى Job
        foreach ($this->previewBusinesses as $row) {
            $row['user_id'] = Auth::id();
            $row['category_id'] = $this->category_id;
            $row['governorate_id'] = $this->governorate_id;
            $row['location_id'] = $this->location_id;

            ImportBusinessRowJob::dispatch($row, Auth::user());
        }

        // ✅ إشعار عام
        Notification::make()
            ->title('✅ تم إرسال جميع الأنشطة إلى المعالجة.')
            ->success()
            ->send();

        // 🕒 ننتظر قليلاً لو أردت، أو نكتفي بتسجيل العدد الحالي
        sleep(1); // اختياري: لأن Jobs تعمل بشكل غير متزامن

        // 🧾 قراءة عدد المحفوظات الفعلية من Cache
        $savedCount = Cache::get($cacheKey, 0);

        // 📝 حفظ سجل الاستيراد
        ImportLog::create([
            'user_id'       => auth()->id(),
            'city_id'       => $this->location_id,
            'category_id'   => $this->category_id,
            'keyword'       => '', // لا توجد كلمات مفتاحية
            'imported_at'   => now(),
            'total_fetched' => $this->previewBusinesses->count(),
            'new_saved'     => $savedCount,
        ]);

        // 🧹 تنظيف Cache
        Cache::forget($cacheKey);
    }


    public function saveSingleBusiness(string $placeId)
    {
        $biz = collect($this->previewBusinesses)->firstWhere('place_id', $placeId);

        if (!$biz) {
            return;
        }

        $biz['user_id'] = Auth::id();
        $biz['category_id'] = $this->category_id;
        $biz['governorate_id'] = $this->governorate_id;
        $biz['location_id'] = $this->location_id;

        ImportBusinessRowJob::dispatch($biz, Auth::user());

        $this->savedPlaces[] = $placeId;

        Notification::make()
            ->title("📤 تم إرسال النشاط '{$biz['name']}' إلى المعالجة")
            ->success()
            ->send();
    }

}
