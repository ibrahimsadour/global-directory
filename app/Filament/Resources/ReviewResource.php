<?php

namespace App\Filament\Resources;

use App\Models\Review;
use App\Filament\Resources\ReviewResource\Pages;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationLabel = 'التقييمات';
    protected static ?string $modelLabel = 'تقييم';
    protected static ?string $pluralModelLabel = 'التقييمات';

    // ✅ نموذج التعديل (form) يُستخدم في التعديل والإنشاء
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('rating')
                ->label('التقييم')
                ->numeric()
                ->required(),

            Textarea::make('message')
                ->label('المحتوى')
                ->required(),

            Toggle::make('is_approved')
                ->label('مقبول'),
        ]);
    }

    // ✅ الجدول الرئيسي
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),

                TextColumn::make('user.name')
                    ->label('المستخدم')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('business.name')
                    ->label('النشاط التجاري')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('rating')
                    ->label('التقييم')
                    ->icon(fn (int $state): string => 'heroicon-o-star')
                    ->color(fn (int $state): string => match (true) {
                        $state >= 5 => 'success',
                        $state >= 3 => 'warning',
                        default     => 'danger',
                    }),

                TextColumn::make('message')
                    ->label('المحتوى')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),

                ToggleColumn::make('is_approved')
                    ->label('مقبول')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger'),

                TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->since(),
            ])
            ->filters([
                SelectFilter::make('is_approved')
                    ->label('حالة التقييم')
                    ->options([
                        true => 'مقبول',
                        false => 'غير مقبول',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('تعديل'),
                Tables\Actions\DeleteAction::make()
                    ->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // ✅ روابط الصفحات
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
