<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return true; // نسمح بالدخول
    }

    public static function canView(Model $record): bool
    {
        return auth()->user()->role === 'admin' || auth()->user()->id === $record->id;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->role === 'admin' || auth()->user()->id === $record->id;
    }

    public static function canCreate(): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->role === 'admin';
    }


    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('الاسم')
                ->required(),

            TextInput::make('email')
                ->label('البريد الإلكتروني')
                ->email()
                ->required(),

            TextInput::make('phone')
                ->label('رقم الهاتف')
                ->tel()
                ->nullable(),

            FileUpload::make('profile_photo')
                ->label('صورة البروفايل')
                ->image()
                ->directory('profile-photos')
                ->disk('public')
                ->visibility('public')
                ->preserveFilenames(false),

            Textarea::make('bio')
                ->label('الوصف (Bio)')
                ->nullable(),

            Select::make('role')
                ->options([
                    'admin' => 'مدير',
                    'user' => 'مستخدم',
                ])
                ->visible(fn () => auth()->user()->role === 'admin')
                ->required(),

            Toggle::make('is_verified')
                ->label('تم التحقق؟')
                ->visible(fn () => auth()->user()->role === 'admin'),

            Toggle::make('status')
                ->label('الحالة (نشط / معطل)')
                ->inline()
                ->visible(fn () => auth()->user()->role === 'admin'),

            TextInput::make('password')
                ->label('كلمة المرور')
                ->password()
                ->required(fn (string $context): bool => $context === 'create')
                ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                ->dehydrated(fn ($state) => filled($state)),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('الاسم')->sortable()->searchable(),

                TextColumn::make('email')->label('البريد الإلكتروني')->sortable()->searchable(),

                BadgeColumn::make('role')
                    ->label('الدور')
                    ->colors([
                        'success' => 'admin',
                        'primary' => 'user',
                    ])
                    ->sortable(),

                IconColumn::make('is_verified')
                    ->label('تم التحقق؟')
                    ->boolean(),

                IconColumn::make('status')
                    ->label('الحالة')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('تصفية حسب الدور')
                    ->options([
                        'admin' => 'مدير',
                        'user' => 'صاحب نشاط',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
