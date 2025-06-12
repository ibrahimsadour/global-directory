<?php

namespace App\Filament\Resources\BusinessResource\Pages;

use App\Filament\Resources\BusinessResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Filament\Forms;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;
use App\Imports\BusinessesImport; // تأكد أنك أنشأت هذا الكلاس كما كتبناه سابقاً

class ListBusinesses extends ListRecords
{
    protected static string $resource = BusinessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(), // زر + إضافة بزنس جديد

Actions\Action::make('importBusinesses')
    ->label('استيراد البزنس (Excel)')
    ->icon('heroicon-o-arrow-down-tray')
    ->form([
        Forms\Components\FileUpload::make('file')
            ->label('اختر ملف Excel')
            ->acceptedFileTypes([
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'text/csv', // ✅ أضف دعم CSV
                'text/plain', // ✅ بعض ملفات CSV تظهر بهذا
            ])
            ->required(),
    ])
    ->action(function (array $data): void {
        \App\Imports\BusinessesImport::$errors = []; // تصفير الأخطاء

        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\BusinessesImport, $data['file']);

        if (count(\App\Imports\BusinessesImport::$errors) > 0) {
            Notification::make()
                ->title('⚠️ تم الاستيراد مع بعض الأخطاء')
                ->body(implode("\n", \App\Imports\BusinessesImport::$errors))
                ->danger()
                ->send();
        } else {
            Notification::make()
                ->title('✅ تم استيراد البزنس بنجاح!')
                ->success()
                ->send();
        }
    }),


        ];
    }
}
