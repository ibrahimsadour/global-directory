<?php

namespace App\Filament\Resources\GovernorateResource\Pages;

use App\Filament\Resources\GovernorateResource;
use App\Imports\GovernoratesImport;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;

class ListGovernorates extends ListRecords
{
    protected static string $resource = GovernorateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('importGovernorates')
                ->label('استيراد المحافظات (Excel)')
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
                    Excel::import(new GovernoratesImport, $data['file']);

                    Notification::make()
                        ->title('تم استيراد المحافظات بنجاح!')
                        ->success()
                        ->send();
                }),
        ];
    }
}
