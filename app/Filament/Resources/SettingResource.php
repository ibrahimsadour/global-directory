<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

        protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Advanced Settings '; // يظهر في السايدبار بهذا الاسم

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([

            \Filament\Forms\Components\TextInput::make('key')
                ->label('المفتاح (Key)')
                ->disabled(fn (?Setting $record) => $record !== null)
                ->required(),

            \Filament\Forms\Components\TextInput::make('group')
                ->label('المجموعة (Group)')
                ->required(),

            \Filament\Forms\Components\TextInput::make('type')
                ->label('نوع الحقل (Type)')
                ->helperText('text, email, url, textarea, image, boolean')
                ->required(),

            \Filament\Forms\Components\Group::make([

                \Filament\Forms\Components\TextInput::make('value')
                    ->label('القيمة (Value)')
                    ->visible(fn (callable $get) => in_array($get('type'), ['text', 'email', 'url']))
                    ->required(),

                \Filament\Forms\Components\Textarea::make('value')
                    ->label('القيمة (Value)')
                    ->visible(fn (callable $get) => in_array($get('type'), ['textarea']))
                    ->required(),

                \Filament\Forms\Components\FileUpload::make('value')
                    ->label('القيمة (Value)')
                    ->directory('site-settings')
                    ->disk('public')
                    ->preserveFilenames(false)
                    ->visible(fn (callable $get) => $get('type') === 'image')
                    ->image()
                    ->openable()
                    ->downloadable()
                    ->imagePreviewHeight(150),

                \Filament\Forms\Components\Toggle::make('value')
                    ->label('القيمة (Value)')
                    ->visible(fn (callable $get) => $get('type') === 'boolean'),
                    
            ])->columnSpanFull(),

        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                \Filament\Tables\Columns\TextColumn::make('group')
                    ->label('المجموعة')
                    ->sortable()
                    ->searchable(),

                \Filament\Tables\Columns\TextColumn::make('key')
                    ->label('المفتاح')
                    ->sortable()
                    ->searchable(),

                \Filament\Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('value')
                    ->label('القيمة')
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->type === 'image' && $state) {
                            $url = asset('storage/' . ltrim($state, '/'));
                            return '<img src="' . $url . '" style="width:50px; height:50px; object-fit:cover; border-radius:6px;" />';
                        }
                        if ($record->type === 'boolean') {
                            return $state ? '✅ نعم' : '❌ لا';
                        }
                        return Str::limit($state, 50);
                    })
                    ->html(),

            ])
            ->defaultSort('group')
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('group')
                    ->label('تصفية حسب المجموعة')
                    ->options(
                        \App\Models\Setting::select('group')->distinct()->pluck('group', 'group')->toArray()
                    ),
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
