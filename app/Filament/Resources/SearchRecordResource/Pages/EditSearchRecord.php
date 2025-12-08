<?php

namespace App\Filament\Resources\SearchRecordResource\Pages;

use App\Filament\Resources\SearchRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSearchRecord extends EditRecord
{
    protected static string $resource = SearchRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
