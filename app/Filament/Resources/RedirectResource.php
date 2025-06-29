<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RedirectResource\Pages;
use App\Filament\Resources\RedirectResource\RelationManagers;
use App\Models\Redirect;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';
    protected static ?string $navigationGroup = '⚙️ الإعدادات';
    protected static ?string $navigationLabel = 'إعادة التوجيه';


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('source_url')
                ->label('الرابط الأصلي')
                ->required()
                ->prefix('/')
                ->maxLength(255)
                ->helperText('مثال: /old-page أو /categories/retail-shops')
                ->columnSpanFull(),

            Forms\Components\TextInput::make('target_url')
                ->label('الرابط الجديد')
                ->required()
                ->maxLength(255)
                ->helperText('مثال: /new-page أو /')
                ->columnSpanFull(),

            Forms\Components\Select::make('status_code')
                ->label('رمز الحالة')
                ->required()
                ->options([
                    301 => '301 - دائم',
                    302 => '302 - مؤقت',
                ])->default(301)->label('كود التحويل'),

            Forms\Components\Toggle::make('active')
                ->label('الرابط مفعل؟')
                ->inline(false)
                ->default(true)
                ->required(),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('source_url')->label('من رابط')->wrap()->searchable(),
                Tables\Columns\TextColumn::make('target_url')->label('إلى رابط')->wrap()->searchable(),
                Tables\Columns\BadgeColumn::make('status_code')->label('الحالة')
                    ->colors([
                        'success' => 301,
                        'warning' => 302,
                    ]),
                Tables\Columns\ToggleColumn::make('active')
                    ->label('الحالة')
                    ->onColor('success')
                    ->offColor('danger'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListRedirects::route('/'),
            'create' => Pages\CreateRedirect::route('/create'),
            'edit' => Pages\EditRedirect::route('/{record}/edit'),
        ];
    }
}
