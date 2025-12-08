<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SearchRecordResource\Pages;
use App\Models\SearchRecord;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class SearchRecordResource extends Resource
{
    protected static ?string $model = SearchRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $modelLabel = 'إحصائية بحث';
    protected static ?string $pluralModelLabel = 'إحصائيات البحث';
    protected static ?int $navigationSort = 10; 

    // 💡 لم نعد نحتاج دالة getTableRecordKeyName()، لأننا سنقوم بتغيير اسم المفتاح في الاستعلام
    // public static function getTableRecordKeyName(): string
    // {
    //     return 'search_term';
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    // 🚀 دالة تجميع البيانات المُعدلة لحل مشكلة المفتاح
    public static function getEloquentQuery(): Builder
    {
        // نستخدم 'search_term as id' لإرضاء متطلبات Filament لمفتاح فريد (id)
        return parent::getEloquentQuery()
            ->selectRaw('search_term as id, search_term, COUNT(*) as count, MAX(created_at) as last_searched_at')
            // تجميع النتائج حسب الكلمة البحثية
            ->groupBy('search_term')
            // ترتيب النتائج تنازلياً حسب عدد مرات البحث
            ->orderByDesc('count');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 1. الكلمة البحثية
                TextColumn::make('search_term')
                    ->label('الكلمة البحثية')
                    ->searchable() 
                    ->sortable(),

                // 2. عدد مرات البحث (العمود الجديد)
                TextColumn::make('count')
                    ->label('عدد مرات البحث')
                    ->numeric()
                    ->sortable()
                    ->color('primary')
                    ->badge(),

                // 3. آخر تاريخ ووقت للبحث (العمود الجديد)
                TextColumn::make('last_searched_at')
                    ->label('آخر بحث')
                    ->dateTime('Y-m-d H:i:s') 
                    ->sortable(),
            ])
            ->filters([
                // يمكن ترك الفلاتر كما هي
            ])
            ->actions([
                // يفضل إزالة الإجراءات (Actions) لأن هذا عرض إحصائي وليس لتعديل السجلات الفردية
            ])
            ->bulkActions([
                // يفضل إزالة الإجراءات الجماعية
            ]);
    }

    // 💡 تعطيل صفحات الإنشاء والتعديل والحذف
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSearchRecords::route('/'),
        ];
    }
}