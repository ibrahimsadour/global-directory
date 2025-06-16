<?php

namespace App\Filament\Resources\BusinessResource\Pages;

use App\Filament\Resources\BusinessResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBusiness extends CreateRecord
{
    protected static string $resource = BusinessResource::class;

    protected function beforeFill(): void
    {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        foreach ($days as $day) {
            $this->form->fill([
                $day . '_open' => null,
                $day . '_close' => null,
            ]);
        }
    }

    protected function afterCreate(): void
    {
        $this->saveSeoData();
        $this->saveOpeningHours();
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

    protected function saveOpeningHours(): void
    {
        $data = $this->form->getState();

        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        foreach ($days as $day) {
            $this->record->hours()->updateOrCreate(
                ['day' => $day],
                [
                    'open_time' => $data[$day . '_open'] ?? null,
                    'close_time' => $data[$day . '_close'] ?? null,
                ]
            );
        }
    }


}
