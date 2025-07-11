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
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\ToggleColumn;

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
            Forms\Components\TextInput::make('password')
                ->password()
                ->label('كلمة المرور')
                ->dehydrated(fn ($state) => filled($state))
                ->required(fn (Page $livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                ->minLength(8)
                ->autocomplete('new-password'),
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

                ToggleColumn::make('status')
                    ->label('مفعل؟')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')->options([
                    'admin' => 'مدير',
                    'user' => 'مستخدم',
                ])->label('حسب الدور'),
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make()
                    ->label('') // تعيين نص فارغ
                    ->icon('heroicon-o-pencil')
                    ->button()
                    ->color('info'),

                \Filament\Tables\Actions\DeleteAction::make()
                    ->label('') // تعيين نص فارغ
                    ->icon('heroicon-o-trash')
                    ->button()
                    ->color('danger'),
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
