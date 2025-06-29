<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Enums\IconSize;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'المستخدمين';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('email')->email()->required(),
            Forms\Components\Select::make('role')->options([
                'admin' => 'مدير',
                'user' => 'مستخدم',
            ])->required(),
            Forms\Components\TextInput::make('phone'),
            Forms\Components\FileUpload::make('profile_photo')->image(),
            Forms\Components\Textarea::make('bio'),
            Forms\Components\Toggle::make('is_verified')->label('تم التحقق؟'),
            Forms\Components\Toggle::make('is_trusted')->label('موثوق؟'),
            Forms\Components\Toggle::make('status')->label('نشط؟'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_photo')
                    ->label('الصورة')
                    ->circular()
                    ->height(40)
                    ->width(40),

                TextColumn::make('name')
                    ->searchable()
                    ->label('الاسم'),

                TextColumn::make('email')
                    ->searchable()
                    ->label('البريد الإلكتروني'),

                TextColumn::make('provider')
                    ->label('مصدر التسجيل')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'google' => 'Google',
                            'facebook' => 'Facebook',
                            'twitter' => 'Twitter',
                            'linkedin' => 'LinkedIn',
                            default => 'محلي',
                        };
                    }),

                TextColumn::make('phone')
                    ->label('الهاتف')
                    ->sortable(),

                BadgeColumn::make('role')
                    ->label('الدور')
                    ->colors([
                        'info' => fn ($state) => $state === 'admin',
                        'gray' => fn ($state) => $state === 'user',
                    ])
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'admin' => '🛡️ مدير',
                            'user' => '🧑 مستخدم',
                            default => '❔ غير معروف',
                        };
                    })
                    ->html(),

                BadgeColumn::make('status')
                    ->label('الحالة')
                    ->colors([
                        'success' => fn ($state): bool => $state == 1,
                        'gray' => fn ($state): bool => $state == 0,
                    ])
                    ->formatStateUsing(function ($state) {
                        return $state == 1
                            ? '✅ نشط'
                            : '❌ معطل ';
                    })
                    ->html(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')->options([
                    'admin' => 'مدير',
                    'user' => 'مستخدم',
                ])->label('حسب الدور'),
            ])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
