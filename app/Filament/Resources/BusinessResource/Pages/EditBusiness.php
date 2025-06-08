<?php

namespace App\Filament\Resources\BusinessResource\Pages;

use App\Filament\Resources\BusinessResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBusiness extends EditRecord
{
    protected static string $resource = BusinessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeFill(): void
    {
        $hours = $this->record->hours()->get()->keyBy('day');

        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        foreach ($days as $day) {
            $this->form->fill([
                $day . '_open' => $hours[$day]->open_time ?? null,
                $day . '_close' => $hours[$day]->close_time ?? null,
            ]);
        }
    }

    protected function afterSave(): void
    {
        $this->saveSeoData();
        $this->saveOpeningHours();
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
