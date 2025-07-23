<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('معلومات الصفحة')
                    ->schema([
                        TextInput::make('title')
                            ->label('عنوان الصفحة')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->label('الرابط (slug)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->rules([
                                'not_in:admin,login,register,logout,categories,businesses,blog,contact,faq,dashboard,filament',
                            ])
                            ->helperText('مثلاً: about أو contact-us'),

                        FileUpload::make('image')
                            ->label('صورة الصفحة')
                            ->image()
                            ->directory('pages-images')
                            ->imagePreviewHeight('150'),

                        RichEditor::make('content')
                            ->label('محتوى الصفحة')
                            ->columnSpanFull(),
                    ]),

                Section::make('إعدادات إضافية')
                    ->collapsed()
                    ->schema([
                        Toggle::make('is_active')
                            ->label('تفعيل الصفحة')
                            ->default(true),

                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(255),

                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('العنوان')->searchable(),
                TextColumn::make('slug')->label('الرابط'),
                IconColumn::make('is_active')
                    ->label('نشطة؟')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('آخر تعديل')
                    ->dateTime('Y-m-d H:i'),
            ])
            ->defaultSort('updated_at', 'desc');
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
