<?php

namespace App\Filament\Resources\SearchRecordResource\Pages;

use App\Filament\Resources\SearchRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSearchRecords extends ListRecords
{
    protected static string $resource = SearchRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
