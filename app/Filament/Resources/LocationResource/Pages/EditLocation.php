<?php

namespace App\Filament\Resources\LocationResource\Pages;

use App\Filament\Resources\LocationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLocation extends EditRecord
{
    protected static string $resource = LocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $this->saveSeoData();
    }

    protected function saveSeoData(): void
    {
        $data = $this->form->getState();

        $seo = $this->record->seo;

        if ($seo) {
            $seo->update([
                'meta_title' => $data['seo']['meta_title'] ?? null,
                'meta_description' => $data['seo']['meta_description'] ?? null,
                'meta_keywords' => $data['seo']['meta_keywords'] ?? null,
            ]);
        } else {
            $this->record->seo()->create([
                'meta_title' => $data['seo']['meta_title'] ?? null,
                'meta_description' => $data['seo']['meta_description'] ?? null,
                'meta_keywords' => $data['seo']['meta_keywords'] ?? null,
            ]);
        }
    }
}
