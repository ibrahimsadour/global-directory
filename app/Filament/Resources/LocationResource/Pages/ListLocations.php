<?php

namespace App\Filament\Resources\LocationResource\Pages;

use App\Filament\Resources\LocationResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Filament\Forms;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;
use App\Imports\LocationsImport;

class ListLocations extends ListRecords
{
    protected static string $resource = LocationResource::class;


   protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(), // زر + إضافة مدينة

            Actions\Action::make('importLocations')
                ->label('استيراد المدن (Excel)')
                ->icon('heroicon-o-arrow-down-tray')
                ->form([
                    Forms\Components\FileUpload::make('file')
                        ->label('اختر ملف Excel')
                        ->acceptedFileTypes([
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        ])
                        ->required(),
                ])
                ->action(function (array $data): void {
                    Excel::import(new \App\Imports\LocationsImport, $data['file']);

                    Notification::make()
                        ->title('✅ تم استيراد المدن بنجاح!')
                        ->success()
                        ->send();
                }),
        ];
    }

}
