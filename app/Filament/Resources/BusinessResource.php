<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessResource\Pages;
use App\Filament\Resources\BusinessResource\RelationManagers;
use App\Models\Business;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Illuminate\Support\Str;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\Actions\Action;
use App\Models\User;
use Filament\Tables\Columns\ToggleColumn;

class BusinessResource extends Resource
{
    protected static ?string $model = Business::class;


    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationLabel = 'الإعلانات'; // يظهر في السايدبار بهذا الاسم

    public static function form(Form $form): Form
    {
        return $form->schema([

            Grid::make()
                ->columns(2)
                ->schema([

                    // ✅ العمود 1 → Tabs
                    \Filament\Forms\Components\Group::make([

                        Tabs::make('Business Tabs')->tabs([

                            Tab::make('البيانات الأساسية')->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('name')
                                        ->label('اسم النشاط')
                                        ->required()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),

                                    TextInput::make('slug')
                                        ->label('الرابط (Slug)')
                                        ->required()
                                        ->unique(ignoreRecord: true)
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            $set('slug', preg_replace('/\s+/', '-', trim($state)));
                                        }),
                                ]),

                                Textarea::make('description')
                                    ->label('وصف النشاط')
                                    ->rows(4)
                                    ->columnSpanFull()
                                    ->placeholder('يمكنك كتابة وصف تعريفي عن هذا النشاط لتحسين ظهوره في محركات البحث (SEO).'),

                                Grid::make()->schema([

                                        Select::make('user_id')
                                            ->label('صاحب النشاط')
                                            ->relationship('user', 'name')
                                            ->required()
                                            ->columnSpanFull(),

                                    Select::make('category_id')
                                        ->label('الفئة')
                                        ->options(\App\Models\Category::pluck('name', 'id')->toArray())
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->columnSpanFull(),

                                Grid::make(2)->schema([

                                    Select::make('governorate_id')
                                        ->label('المحافظة')
                                        ->relationship('governorate', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->reactive()
                                        ->afterStateUpdated(function (callable $set) {
                                            // عند تغيير المحافظة → نفرّغ المدينة حتى لا يحصل mismatch
                                            $set('location_id', null);
                                        }),

                                    Select::make('location_id')
                                        ->label('المدينة / المحافظة')
                                        ->options(function (callable $get) {
                                            $governorate = $get('governorate_id');
                                            $governorateId = is_object($governorate) ? $governorate?->id : $governorate;

                                            if (!$governorateId) {
                                                return [];
                                            }

                                            return \App\Models\Location::where('governorate_id', $governorateId)
                                                ->pluck('area', 'id');
                                        })
                                        ->searchable()
                                        ->required()
                                        ->hint(fn (callable $get) => !$get('governorate_id') ? 'اختر المحافظة أولاً' : null)
                                        ->visible(fn (callable $get) => !!$get('governorate_id')), // ✅ يظهر فقط عند اختيار المحافظة
                                    ]), 
                                    Grid::make(2)->schema([
                                        TextInput::make('phone')
                                            ->label('رقم الهاتف')
                                            ->placeholder('مثال: 965XXXXXXXX'),

                                        TextInput::make('email')
                                            ->label('البريد الإلكتروني')
                                            ->placeholder('info@example.com'),
                                    ]),

                                    Grid::make(2)->schema([
                                        TextInput::make('website')
                                            ->label('رابط الموقع')
                                            ->url()
                                            ->placeholder('https://example.com'),

                                        TextInput::make('whatsapp')
                                            ->label('رقم واتساب')
                                            ->placeholder('مثال: 965XXXXXXXX')
                                            ->tel(),
                                    ]),

                                    Grid::make(3)->schema([
                                        Toggle::make('is_featured')
                                            ->label('مميز؟')
                                            ->default(false),

                                        Toggle::make('is_approved')
                                            ->label('مقبول؟')
                                            ->default(true),

                                        Toggle::make('is_active')
                                            ->label('مفعل؟')
                                            ->default(true),
                                    ]),

                                ])->columnSpanFull(),

                            ]),

                            Tab::make('صورة النشاط')->schema([
                                FileUpload::make('image')
                                    ->label('صورة النشاط')
                                    ->image()
                                    ->directory('business-images')
                                    ->disk('public')
                                    ->visibility('public')
                                    ->preserveFilenames(false)
                                    ->getUploadedFileNameForStorageUsing(function ($file) {
                                        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                        $extension = $file->getClientOriginalExtension();
                                        return Str::slug($name) . '-' . uniqid() . '.' . $extension;
                                    })
                                    ->openable()
                                    ->downloadable()
                                    ->imagePreviewHeight(200)
                                    ->previewable(true),

                                FileUpload::make('gallery')
                                    ->label('معرض الصور (Gallery)')
                                    ->multiple()
                                    ->image()
                                    ->reorderable() // ✅ يمكن ترتيب الصور Drag & Drop
                                    ->maxFiles(10) // ✅ حد أقصى للصور (مثلاً 10)
                                    ->directory('business-gallery')
                                    ->disk('public')
                                    ->visibility('public')
                                    ->preserveFilenames(false)
                                    ->getUploadedFileNameForStorageUsing(function ($file) {
                                        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                        $extension = $file->getClientOriginalExtension();
                                        return Str::slug($name) . '-' . uniqid() . '.' . $extension;
                                    })
                                    ->openable()
                                    ->downloadable()
                                    ->imagePreviewHeight(200) // ✅ عرض معاينة أفضل
                                    ->previewable(true),

                            ]),

                            Tab::make('معلومات إضافية')->schema([

                                Fieldset::make('أوقات الدوام')->schema([


                                    Grid::make(3)->schema([

                                        Toggle::make('monday_closed')->label('الاثنين مغلق؟')->default(false),
                                        TimePicker::make('monday_open')->label('الاثنين (فتح)')->step(3600)
                                            ->disabled(fn (callable $get) => $get('monday_closed')),
                                        TimePicker::make('monday_close')->label('الاثنين (إغلاق)')->step(3600)
                                            ->disabled(fn (callable $get) => $get('monday_closed')),

                                        Toggle::make('tuesday_closed')->label('الثلاثاء مغلق؟')->default(false),
                                        TimePicker::make('tuesday_open')->label('الثلاثاء (فتح)')->step(3600)
                                            ->disabled(fn (callable $get) => $get('tuesday_closed')),
                                        TimePicker::make('tuesday_close')->label('الثلاثاء (إغلاق)')->step(3600)
                                            ->disabled(fn (callable $get) => $get('tuesday_closed')),

                                        Toggle::make('wednesday_closed')->label('الأربعاء مغلق؟')->default(false),
                                        TimePicker::make('wednesday_open')->label('الأربعاء (فتح)')->step(3600)
                                            ->disabled(fn (callable $get) => $get('wednesday_closed')),
                                        TimePicker::make('wednesday_close')->label('الأربعاء (إغلاق)')->step(3600)
                                            ->disabled(fn (callable $get) => $get('wednesday_closed')),

                                        Toggle::make('thursday_closed')->label('الخميس مغلق؟')->default(false),
                                        TimePicker::make('thursday_open')->label('الخميس (فتح)')->step(3600)
                                            ->disabled(fn (callable $get) => $get('thursday_closed')),
                                        TimePicker::make('thursday_close')->label('الخميس (إغلاق)')->step(3600)
                                            ->disabled(fn (callable $get) => $get('thursday_closed')),

                                        Toggle::make('friday_closed')->label('الجمعة مغلق؟')->default(false),
                                        TimePicker::make('friday_open')->label('الجمعة (فتح)')->step(3600)
                                            ->disabled(fn (callable $get) => $get('friday_closed')),
                                        TimePicker::make('friday_close')->label('الجمعة (إغلاق)')->step(3600)
                                            ->disabled(fn (callable $get) => $get('friday_closed')),

                                        Toggle::make('saturday_closed')->label('السبت مغلق؟')->default(false),
                                        TimePicker::make('saturday_open')->label('السبت (فتح)')->step(3600)
                                            ->disabled(fn (callable $get) => $get('saturday_closed')),
                                        TimePicker::make('saturday_close')->label('السبت (إغلاق)')->step(3600)
                                            ->disabled(fn (callable $get) => $get('saturday_closed')),

                                        Toggle::make('sunday_closed')->label('الأحد مغلق؟')->default(false),
                                        TimePicker::make('sunday_open')->label('الأحد (فتح)')->step(3600)
                                            ->disabled(fn (callable $get) => $get('sunday_closed')),
                                        TimePicker::make('sunday_close')->label('الأحد (إغلاق)')->step(3600)
                                            ->disabled(fn (callable $get) => $get('sunday_closed')),
                                    ]),

                                ]),


                                Fieldset::make('روابط التواصل الاجتماعي')->schema([
                                    TextInput::make('facebook')->label('رابط Facebook')->url(),
                                    TextInput::make('instagram')->label('رابط Instagram')->url(),
                                    TextInput::make('twitter')->label('رابط Twitter')->url(),
                                    TextInput::make('linkedin')->label('رابط LinkedIn')->url(),
                                    TextInput::make('youtube')->label('رابط YouTube')->url(),
                                ]),

                            ]),

                            Tab::make('إعدادات SEO')->schema([

                                Fieldset::make('بيانات السيو')
                                    ->statePath('seo')
                                    ->default([
                                        'meta_title' => '',
                                        'meta_description' => '',
                                        'meta_keywords' => '',
                                    ])
                                    ->schema([  

                                        TextInput::make('meta_title')
                                            ->label('عنوان الميتا')
                                            ->helperText(function ($state) {
                                                $length = mb_strlen($state);
                                                return "عدد الأحرف: {$length} / 60 — يفضل أن لا يزيد عن 60 حرف";
                                            })
                                            ->columnSpanFull()
                                            ->maxLength(60)
                                            ->live() // لتحديث helperText بشكل مباشر
                                            ->afterStateHydrated(function ($component, $state) use ($form) {
                                                $component->state(
                                                    $form->getRecord()?->seo?->meta_title
                                                );
                                            }),

                                        Textarea::make('meta_description')
                                            ->label('وصف الميتا')
                                            ->helperText(function ($state) {
                                                $length = mb_strlen($state);
                                                return "عدد الأحرف: {$length} / 160 — يفضل أن لا يزيد عن 160 حرف (هو الذي يظهر تحت العنوان في محركات البحث)";
                                            })
                                            ->columnSpanFull()
                                            ->maxLength(160)
                                            ->live() // لتحديث helperText بشكل مباشر
                                            ->afterStateHydrated(function ($component, $state) use ($form) {
                                                $component->state(
                                                    $form->getRecord()?->seo?->meta_description
                                                );
                                            }),

                                        TextInput::make('meta_keywords')
                                            ->label('الكلمات المفتاحية')
                                            ->columnSpanFull()
                                            ->helperText('ضع الكلمات مفصولة بفواصل، مثال: تنظيف منازل، غسيل سيارات، تكييف، تصليح كهرباء')
                                            ->afterStateHydrated(function ($component, $state) use ($form) {
                                                $component->state(
                                                    $form->getRecord()?->seo?->meta_keywords
                                                );
                                            }),

                                    ]),

                            ]),



                        ]),

                    ]), // نهاية العمود الأول

                    // ✅ العمود 2 → العنوان + الخريطة
                    \Filament\Forms\Components\Group::make([

                        Fieldset::make('اختيار العنوان على الخريطة')->schema([

                            TextInput::make('address')
                                ->label('العنوان')
                                ->required()
                                ->placeholder('الفروانية - شارع 75'),

                            Grid::make(2)->schema([
                                TextInput::make('latitude')
                                    ->label('خط العرض (Latitude)')
                                    ->numeric()
                                    ->placeholder('مثلاً: 29.3759'),

                                TextInput::make('longitude')
                                    ->label('خط الطول (Longitude)')
                                    ->numeric()
                                    ->placeholder('مثلاً: 47.9774'),
                            ]),

                            ViewField::make('map_picker')
                                ->label('الخريطة')
                                ->view('filament.components.map-picker')
                                ->columnSpanFull(),

                        ])->columnSpanFull(),

                    ]), // نهاية العمود الثاني

                ]), // نهاية Grid

        ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('id')
                    ->label(' ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('image')
                    ->label('صورة')
                    ->formatStateUsing(function ($state, $record) {
                        if (empty($state)) {
                            $imageUrl = asset('storage/business_photos/default.webp');
                        } elseif (Str::startsWith($state, 'http')) {
                            $imageUrl = $state;
                        } elseif (Str::contains($state, '/')) {
                            $imageUrl = asset('storage/' . ltrim($state, '/'));
                        } else {
                            $imageUrl = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photo_reference=' 
                                . $state . '&key=' . config('services.google.maps_api_key');
                        }

                        return '<img src="' . $imageUrl . '" style="width:60px; height:60px; border-radius:5%; object-fit:cover;" />';
                    })
                    ->html(),

                Tables\Columns\TextColumn::make('name')
                    ->label('العنوان')
                    ->limit(20)
                    ->searchable()
                    ->sortable(),                    

                // ✅ عمود المستخدم
                Tables\Columns\TextColumn::make('user.name')
                    ->label('المستخدم')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('الفئة')
                    ->formatStateUsing(function ($state, $record) {
                        $category = $record->category;
                        if (!$category) return '—';

                        $parentName = $category->parent?->name;
                        return $parentName
                            ? "{$parentName} / {$category->name}"
                            : $category->name;
                    })
                    ->color(function ($record) {
                        $category = $record->category;
                        if (!$category) return 'gray';

                        return $category->parent ? 'success' : 'primary';
                    })
                    ->sortable()
                    ->badge(),

                Tables\Columns\TextColumn::make('location.area')
                    ->label('المحافظة / المدينة')
                    ->formatStateUsing(function ($state, $record) {
                        $governorate = $record->governorate?->name ?? ($record->location->governorate?->name ?? '—');
                        $area = $record->location?->area ?? '—';
                        return "{$governorate} / {$area}";
                    })
                    ->sortable()
                    ->badge(),

                ToggleColumn::make('is_approved')
                    ->label('مقبول؟')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger'),

                ToggleColumn::make('is_active')
                    ->label('مفعل؟')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger'),

                ToggleColumn::make('is_featured')
                    ->label('مميز')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger'),


                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime('Y-m-d')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('فلتر حسب الفئة')
                    ->relationship('category', 'name'),

                Tables\Filters\SelectFilter::make('location_id')
                    ->label('فلتر حسب المدينة / المحافظة')
                    ->relationship('location', 'area'),

                Tables\Filters\SelectFilter::make('user_id')
                    ->label('فلتر حسب المستخدم')
                    ->relationship('user', 'name'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('فلتر حسب حالة التفعيل'),

                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('فلتر حسب حالة القبول'),
            ])
            ->actions([

                \Filament\Tables\Actions\EditAction::make()
                    ->label('') // تعيين نص فارغ
                    ->icon('heroicon-o-pencil')
                    ->button()
                    ->color('info'),

                \Filament\Tables\Actions\DeleteAction::make()
                    ->label('') // تعيين نص فارغ
                    ->icon('heroicon-o-trash')
                    ->button()
                    ->color('danger'),
                \Filament\Tables\Actions\Action::make('viewFrontend')
                    ->label('') // بدون نص
                    ->icon('heroicon-o-eye') // أيقونة "عين"
                    ->button()
                    ->url(fn ($record) => route('business.show', $record->slug))
                    ->openUrlInNewTab()
                    ->color('success'),

            ])
            ->bulkActions([
                \Filament\Tables\Actions\DeleteBulkAction::make()
                    ->label('حذف المحدد')
                    ->color('danger'),
            ])
            ->defaultSort('created_at', 'desc');
    }






    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBusinesses::route('/'),
            'create' => Pages\CreateBusiness::route('/create'),
            'edit' => Pages\EditBusiness::route('/{record}/edit'),
        ];
    }
}
