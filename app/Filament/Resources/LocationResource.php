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

                    TextInput::make('latitude')
                        ->label('خط العرض (Latitude)')
                        ->numeric()
                        ->placeholder('مثلاً: 29.3759'),

                    TextInput::make('longitude')
                        ->label('خط الطول (Longitude)')
                        ->numeric()
                        ->placeholder('مثلاً: 47.9774'),

                    Toggle::make('is_active')
                        ->label('مفعل؟')
                        ->default(true),

                ]), // نهاية Tab البيانات الأساسية

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

                TextColumn::make('governorate.name')
                    ->label('المحافظة')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('image')
                    ->label('صورة المدينة')
                    ->formatStateUsing(function ($state) {
                        if ($state && is_string($state)) {
                            $url = asset('storage/' . ltrim($state, '/'));
                            return '<img src="' . $url . '" style="width:60px; height:60px; border-radius:50%; object-fit:cover;" />';
                        }
                        return 'لا توجد صورة';
                    })
                    ->html(),

                TextColumn::make('area')
                    ->label('اسم المنطقة / المدينة')
                    ->searchable()
                    ->sortable(),

                ToggleColumn::make('is_active')
                    ->label('مفعل؟')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger'),
            ])
            ->actions([

                \Filament\Tables\Actions\EditAction::make()
                    ->label('تعديل')
                    ->icon('heroicon-o-pencil')
                    ->button()
                    ->color('info'),

                \Filament\Tables\Actions\DeleteAction::make()
                    ->label('حذف')
                    ->icon('heroicon-o-trash')
                    ->button()
                    ->color('danger'),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\DeleteBulkAction::make()
                    ->label('حذف المحدد')
                    ->color('danger'),
            ])
            ->defaultSort('id', 'desc'); // ترتيب افتراضي اختياري (آخر فئة أولاً)
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
