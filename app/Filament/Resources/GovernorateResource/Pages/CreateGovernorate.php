<?php

namespace App\Filament\Resources\GovernorateResource\Pages;

use App\Filament\Resources\GovernorateResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGovernorate extends CreateRecord
{
    protected static string $resource = GovernorateResource::class;

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
