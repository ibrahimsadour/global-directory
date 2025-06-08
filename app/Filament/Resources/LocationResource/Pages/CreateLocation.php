<?php

namespace App\Filament\Resources\LocationResource\Pages;

use App\Filament\Resources\LocationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLocation extends CreateRecord
{
    protected static string $resource = LocationResource::class;

    protected function afterCreate(): void
    {
        $this->saveSeoData();
    }

    protected function saveSeoData(): void
    {
        $data = $this->form->getState();

        $this->record->seo()->create([
            'meta_title' => $data['seo']['meta_title'] ?? null,
            'meta_description' => $data['seo']['meta_description'] ?? null,
            'meta_keywords' => $data['seo']['meta_keywords'] ?? null,
        ]);
    }
}
