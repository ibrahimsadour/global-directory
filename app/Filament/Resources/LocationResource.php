<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationResource\Pages;
use App\Models\Location;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Str;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Fieldset;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Filters\SelectFilter;
use App\Models\Governorate;
class LocationResource extends Resource
{
    protected static ?string $model = Location::class;
    protected static ?string $navigationLabel = 'المدن'; // يظهر في السايدبار بهذا الاسم

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    

    public static function form(Form $form): Form
    {
        return $form->schema([

            Tabs::make('Location Tabs')->tabs([

                Tab::make('البيانات الأساسية')->schema([

                    Select::make('governorate_id')
                        ->label('المحافظة')
                        ->relationship('governorate', 'name')
                        ->required(),

                    TextInput::make('area')
                        ->label('اسم المنطقة / المدينة')
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

                    FileUpload::make('image')
                        ->label('صورة المنطقة / المدينة')
                        ->image()
                        ->directory('location-images')
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

                    Textarea::make('description')
                        ->label('وصف المنطقة / المدينة')
                        ->rows(4)
                        ->placeholder('يمكنك كتابة وصف تعريفي عن هذه المنطقة لتحسين ظهورها في محركات البحث (SEO).'),

                    Toggle::make('is_active')
                        ->label('مفعل؟')
                        ->default(true),

                ]), // نهاية Tab البيانات الأساسية
                
                Tab::make('العنوان')->schema([

                    TextInput::make('latitude')
                        ->label('خط العرض (Latitude)')
                        ->numeric()
                        ->placeholder('مثلاً: 29.3759'),

                    TextInput::make('longitude')
                        ->label('خط الطول (Longitude)')
                        ->numeric()
                        ->placeholder('مثلاً: 47.9774'),
                    Textarea::make('polygon')
                        ->label('إحداثيات المضلع (Polygon)')
                        ->placeholder('مثلاً: [[29.3759, 47.9774], [29.3760, 47.9780], [29.3755, 47.9785]]')
                        ->rows(8) // زيادة الحجم العمودي
                        ->columnSpanFull()
                        ->helperText('أدخل النقاط بصيغة JSON أو كقائمة من الإحداثيات [lat, lng]')
                        ->extraAttributes([
                            'dir' => 'ltr',           // اتجاه النص من اليسار لليمين
                            'style' => 'font-family: monospace; font-size: 14px;', // خط موحد لتسهيل القراءة
                        ]),

                ]), 
                
                // نهاية Tab البيانات الأساسية
                Tab::make('إعدادات SEO')->schema([

                    Fieldset::make('بيانات السيو')
                        ->statePath('seo')
                        ->schema([

                            TextInput::make('meta_title')
                                ->label('عنوان الميتا')
                                ->afterStateHydrated(function ($component, $state) use ($form) {
                                    $component->state(
                                        $form->getRecord()?->seo?->meta_title
                                    );
                                }),

                            Textarea::make('meta_description')
                                ->label('وصف الميتا')
                                ->afterStateHydrated(function ($component, $state) use ($form) {
                                    $component->state(
                                        $form->getRecord()?->seo?->meta_description
                                    );
                                }),

                            TextInput::make('meta_keywords')
                                ->label('الكلمات المفتاحية')
                                ->afterStateHydrated(function ($component, $state) use ($form) {
                                    $component->state(
                                        $form->getRecord()?->seo?->meta_keywords
                                    );
                                }),

                        ]), // نهاية Fieldset

                ]), // نهاية Tab إعدادات SEO

            ]), // نهاية Tabs

        ]); // نهاية schema
    }

public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('id')
                ->label('ID')
                ->sortable(),

            TextColumn::make('governorate_and_area')
                ->label('الموقع (المحافظة / المدينة)')
                ->getStateUsing(function ($record) {
                    return "{$record->governorate->name} / {$record->area}";
                })
                ->searchable()
                ->sortable(),

            TextColumn::make('image')
                ->label('الصورة')
                ->formatStateUsing(function ($state, $record) {
                    if ($state && is_string($state)) {
                        $url = asset('storage/' . ltrim($state, '/'));
                        return '<img src="' . $url . '" title="' . $record->area . '" style="width:60px; height:60px; border-radius:50%; object-fit:cover;" />';
                    }
                    return 'لا توجد صورة';
                })
                ->html(),

            TextColumn::make('businesses_count')
                ->label('عدد النشاطات')
                ->counts('businesses')
                ->sortable(),

            ToggleColumn::make('is_active')
                ->label('مفعل؟')
                ->onIcon('heroicon-o-check-circle')
                ->offIcon('heroicon-o-x-circle')
                ->onColor('success')
                ->offColor('danger'),
        ])
        ->filters([
            SelectFilter::make('governorate_id')
                ->label('المحافظة')
                ->relationship('governorate', 'name')
                ->searchable()
                ->preload(),
        ])
        ->actions([
            Tables\Actions\EditAction::make()
                ->label('تعديل')
                ->icon('heroicon-o-pencil')
                ->button()
                ->color('info'),

            Tables\Actions\DeleteAction::make()
                ->label('حذف')
                ->icon('heroicon-o-trash')
                ->button()
                ->color('danger'),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make()
                ->label('حذف المحدد')
                ->color('danger'),
        ])
        ->defaultSort('id', 'desc');
}


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}
