<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImportLogResource\Pages;
use App\Models\ImportLog;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;

class ImportLogResource extends Resource
{
    protected static ?string $model = ImportLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $navigationGroup = 'النظام';
    protected static ?string $label = 'سجل الاستيراد';
    protected static ?string $pluralLabel = 'سجلات الاستيراد';
    protected static ?string $navigationLabel = 'سجلات الاستيراد';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('user.name')
                ->label('المستخدم')
                ->disabled(),

            TextInput::make('city.area')
                ->label('المنطقة')
                ->disabled(),

            TextInput::make('category.name')
                ->label('التصنيف')
                ->disabled(),

            TextInput::make('keyword')
                ->label('الكلمة المفتاحية')
                ->disabled(),


            TextInput::make('total_fetched')
                ->label('عدد النتائج من Google')
                ->disabled(),

            TextInput::make('new_saved')
                ->label('عدد النشاطات الجديدة المحفوظة')
                ->disabled(),

            DateTimePicker::make('imported_at')
                ->label('وقت الاستيراد')
                ->disabled(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('المستخدم')->searchable(),
                TextColumn::make('city.area')->label('المنطقة')->searchable(),
                TextColumn::make('category.name')->label('التصنيف')->searchable(),
                TextColumn::make('keyword')->label('الكلمة المفتاحية'),
                TextColumn::make('radius')->label('النطاق')->suffix(' كم'),
                TextColumn::make('total_fetched')->label('تم جلبه')->color('gray'),
                TextColumn::make('new_saved')->label('تم حفظه')->color('success'),
                TextColumn::make('imported_at')->label('وقت الاستيراد')->since(),
            ])
            ->defaultSort('imported_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListImportLogs::route('/'),
            'create' => Pages\CreateImportLog::route('/create'),
            'edit' => Pages\EditImportLog::route('/{record}/edit'),
        ];
    }
}
