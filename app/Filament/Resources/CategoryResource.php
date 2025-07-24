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
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Support\Str;
use App\Models\Business;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'التصنيفات';

    public static function getPluralModelLabel(): string
    {
        return request()->has('parent') ? 'الفئات الفرعية' : 'الفئات الرئيسية';
    }

    public static function getModelLabel(): string
    {
        if (request()->has('parent')) {
            $parent = \App\Models\Category::find(request()->get('parent'));
            return $parent ? 'الفئات الفرعية لـ ' . $parent->name : 'فئات فرعية';
        }
        return 'فئة رئيسية';
    }

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
                            return \App\Models\Category::whereNull('parent_id')
                                ->when($record, fn($query) => $query->where('id', '!=', $record->id))
                                ->pluck('name', 'id');
                        })
                        ->default(request()->get('parent'))
                        ->nullable()
                        ->searchable(),

                    FileUpload::make('image')
                        ->label('صورة الفئة')
                        ->image()
                        ->directory('category-images')
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
                                ->afterStateHydrated(fn($component, $state) => 
                                    $component->state($form->getRecord()?->seo?->meta_title)
                                ),

                            Textarea::make('meta_description')
                                ->label('وصف الميتا')
                                ->afterStateHydrated(fn($component, $state) => 
                                    $component->state($form->getRecord()?->seo?->meta_description)
                                ),

                            TextInput::make('meta_keywords')
                                ->label('الكلمات المفتاحية')
                                ->afterStateHydrated(fn($component, $state) => 
                                    $component->state($form->getRecord()?->seo?->meta_keywords)
                                ),
                        ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),

                TextColumn::make('image')
                    ->label('الصورة')
                    ->formatStateUsing(function ($state) {
                        if ($state && is_string($state)) {
                            $url = asset('storage/' . ltrim($state, '/'));
                            return '<img src="' . $url . '" style="width:60px; height:60px; border-radius:10%; object-fit:cover;" />';
                        }
                        return 'لا توجد صورة';
                    })
                    ->html(),

                TextColumn::make('name')
                    ->label('العنوان')
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->parent_id) {
                            return '<span style="
                                display: inline-block;
                                padding-left: 16px;
                                border-left: 3px solid #3b82f6;
                                color: #1d4ed8;
                                font-weight: 500;
                            ">↰ ' . e($state) . '</span>';
                        }

                        return '<span style="font-weight: 600; color: #111827;">' . e($state) . '</span>';
                    })
                    ->html()
                    ->searchable()
                    ->sortable(),


                BadgeColumn::make('parent_id')
                    ->label('النوع')
                    ->getStateUsing(fn($record) => 
                        $record->parent ? 'فرعية - ' . $record->parent->name : 'فئة رئيسية'
                    )
                    ->colors([
                        'success' => fn($state) => str_contains($state, 'رئيسية'),
                        'warning' => fn($state) => str_contains($state, 'فرعية'),
                    ]),

                TextColumn::make('children_count')
                    ->label('عدد الفئات الفرعية')
                    ->counts('children')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        if ($state > 0) {
                            return '<span style="
                                display: inline-block;
                                padding: 1px 2px;
                                border-radius: 6px;
                                border: 1px solid #3b82f6;
                                color: #1d4ed8;
                                background-color: #eff6ff;
                                font-weight: 500;
                            ">' . $state . ' فئة فرعية</span>';
                        }
                        return '—';
                    })
                    ->html() // ✅ للسماح بعرض HTML
                    ->url(fn($record) => $record->children_count > 0
                        ? route('filament.admin.resources.categories.index', ['parent' => $record->id])
                        : null
                    ),

                TextColumn::make('total_businesses')
                    ->label('عدد النشاطات')
                    ->getStateUsing(fn ($record) => 
                        ($record->businesses_count ?? 0) + $record->children->sum('businesses_count')
                ),


                ToggleColumn::make('is_active')
                    ->label('مفعل؟')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger'),
            ])

            ->filters([
                SelectFilter::make('parent_id')
                    ->label('فلترة حسب الفئة الأم')
                    ->options(fn () => \App\Models\Category::whereNull('parent_id')->pluck('name', 'id'))
                    ->query(fn(Builder $query, array $data) => 
                        !empty($data['value']) ? $query->where('parent_id', $data['value']) : $query
                    ),
            ])

            ->actions([
                EditAction::make()->label('تعديل')->icon('heroicon-o-pencil')->button()->color('info'),
                DeleteAction::make()->label('حذف')->icon('heroicon-o-trash')->button()->color('danger'),
            ])

            ->bulkActions([
                DeleteBulkAction::make()->label('حذف المحدد')->color('danger'),
            ])

            ->headerActions([
                Action::make('back_to_main')
                    ->label('العودة إلى الفئات الرئيسية')
                    ->icon('heroicon-o-arrow-left')
                    ->url(route('filament.admin.resources.categories.index'))
                    ->visible(fn () => request()->has('parent')),
            ])

            ->defaultSort('id', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        // فقط في صفحة الفهرس (index) نقوم بتصفية حسب الفئة الأم
        if (request()->routeIs('filament.admin.resources.categories.index')) {
            $parentId = request()->get('parent');

            return parent::getEloquentQuery()
                ->when($parentId, fn($query) => $query->where('parent_id', $parentId))
                ->when(!$parentId, fn($query) => $query->whereNull('parent_id'))
                ->withCount('businesses', 'children') // نضيف عدد الأنشطة والفرعية
                ->with(['children' => fn($q) => $q->withCount('businesses')]) // نجلب عدد الأنشطة للأبناء
                ->with('parent');
        }

        // في باقي الصفحات (edit, delete, toggle, bulk ...) نرجع الاستعلام كما هو
        return parent::getEloquentQuery()
            ->withCount('businesses', 'children')
            ->with(['children' => fn($q) => $q->withCount('businesses')])
            ->with('parent');
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
