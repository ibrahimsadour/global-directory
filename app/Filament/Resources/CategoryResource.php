<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\Str;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\Action;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    




    public static function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make('Category Tabs')->tabs([
                Tab::make('البيانات الأساسية')->schema([
                    TextInput::make('name')
                        ->label('اسم الفئة')
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

                    Select::make('parent_id')
                        ->label('الفئة الرئيسية')
                        ->options(function ($record) {
                            return \App\Models\Category::where('id', '!=', $record?->id)->pluck('name', 'id');
                        })
                        ->nullable()
                        ->searchable(),


                    FileUpload::make('image')
                        ->label('صورة الفئة')
                        ->image()
                        ->directory('category-images')
                        ->disk('public')
                        ->visibility('public')
                        ->preserveFilenames(false) // نمنع استخدام الاسم الأصلي
                        ->getUploadedFileNameForStorageUsing(function ($file) {
                            $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                            $extension = $file->getClientOriginalExtension();
                            return Str::slug($name) . '-' . uniqid() . '.' . $extension;
                        })
                        ->openable()
                        ->downloadable()
                        ->imagePreviewHeight(200)
                        ->previewable(true),



                    Toggle::make('is_active')
                        ->label('مفعل')
                        ->default(true),

                    Textarea::make('description')
                        ->label('وصف الفئة')
                        ->rows(4)
                        ->placeholder('يمكنك كتابة وصف تعريفي عن هذه الفئة لتحسين ظهورها في محركات البحث.'),
                ]),

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
                    ]),
                ]),

            ]),
        ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('معرّف الفئة')
                    ->sortable(),

                TextColumn::make('image')
                    ->label('صورة الفئة')
                    ->formatStateUsing(function ($state) {
                        if ($state && is_string($state)) {
                            $url = asset('storage/' . ltrim($state, '/'));
                            return '<img src="' . $url . '" style="width:60px; height:60px; border-radius:50%; object-fit:cover;" />';
                        }
                        return 'لا توجد صورة';
                    })
                    ->html(),

                TextColumn::make('name')
                    ->label('اسم الفئة')
                    ->formatStateUsing(function ($state, $record) {
                        // بناء التدرج Hierarchy
                        $prefix = '';
                        $parent = $record->parent;
                        while ($parent) {
                            $prefix = $parent->name . ' → ' . $prefix;
                            $parent = $parent->parent;
                        }
                        return $prefix . $state;
                    })
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\BadgeColumn::make('parent_id')
                    ->label('نوع الفئة')
                    ->getStateUsing(function ($record) {
                        if ($record->parent) {
                            return 'فرعية - ' . $record->parent->name;
                        }
                        return 'فئة رئيسية';
                    })
                    ->colors([
                        'success' => fn ($state) => $state === 'فئة رئيسية',
                        'warning' => fn ($state) => str_starts_with($state, 'فرعية'),
                    ]), 
                    
                // زر Switch بدل أيقونة
                \Filament\Tables\Columns\ToggleColumn::make('is_active')
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
