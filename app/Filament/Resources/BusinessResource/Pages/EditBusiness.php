<?php

namespace App\Filament\Resources\BusinessResource\Pages;

use App\Filament\Resources\BusinessResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;
use App\Traits\HandlesWebpImages;
use Illuminate\Support\Arr;

class EditBusiness extends EditRecord
{
    protected static string $resource = BusinessResource::class;
    use HandlesWebpImages;

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
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // حفظ الصورة والمعرض القديمين قبل أي تعديل
        $oldImage = $this->record->image ?? null;
        $oldGallery = $this->record->gallery ?? [];

        // ✅ الحفاظ على الصورة القديمة إن لم يتم رفع جديدة
        $data = $this->preserveOldImageIfEmpty($data, 'image', $this->record);

        // ✅ التحويل إلى WebP + حذف الصورة القديمة إن وُجدت وتم استبدالها
        if (!empty($data['image'])) {
            $data['image'] = $this->convertImageToWebpIfNeeded($data['image'], $oldImage);
        }

        // ✅ الحفاظ على معرض الصور القديم إن لم يتم رفع جديد
        $data = $this->preserveOldGalleryIfEmpty($data, $this->record);

        // ✅ تحويل المعرض إلى WebP + حذف الصور القديمة التي تم إزالتها
        $data['gallery'] = $this->convertGalleryToWebpIfNeeded($data['gallery'], $oldGallery);

        return $data;
    }


}
