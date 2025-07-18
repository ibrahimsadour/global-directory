<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

trait HandlesWebpImages
{
    /**
     * تحويل صورة واحدة إلى WebP مع ضغطها بجودة 70%.
     */
    protected function convertImageToWebpIfNeeded(string $path, ?string $oldPath = null): string
    {
        $manager = new ImageManager(new \Intervention\Image\Drivers\Gd\Driver());

        if (!Storage::disk('public')->exists($path)) {
            return $path;
        }

        if (Str::endsWith($path, '.webp')) {
            return $path;
        }

        $fullPath = storage_path('app/public/' . $path);

        try {
            $webpImage = $manager->read($fullPath)->toWebp(quality: 60);
            $webpPath = Str::replaceLast(pathinfo($path, PATHINFO_EXTENSION), 'webp', $path);

            Storage::disk('public')->put($webpPath, $webpImage->toString());

            if ($oldPath && $oldPath !== $path && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            Storage::disk('public')->delete($path);

            return $webpPath;
        } catch (\Throwable $e) {
            Log::error('❌ فشل تحويل الصورة إلى WebP: ' . $e->getMessage());
            return $path;
        }
    }


    /**
     * تحويل مجموعة صور (معرض) إلى WebP مع ضغط.
     */
    protected function convertGalleryToWebpIfNeeded(array $gallery, array $oldGallery = []): array
    {
        $converted = [];

        foreach ($gallery as $path) {
            $converted[] = $this->convertImageToWebpIfNeeded($path);
        }

        // حذف الصور القديمة التي لم تعد موجودة
        foreach ($oldGallery as $oldImage) {
            if (!in_array($oldImage, $converted) && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        return $converted;
    }


    /**
     * في حال لم يتم رفع صورة جديدة، نحتفظ بالصورة القديمة.
     */
    protected function preserveOldImageIfEmpty(array $data, string $field, $record): array
    {
        if (empty($data[$field]) && $record->{$field}) {
            $data[$field] = $record->{$field};
        }

        return $data;
    }

    /**
     * في حال لم يتم رفع معرض جديد، نحتفظ بالمعرض القديم.
     */
    protected function preserveOldGalleryIfEmpty(array $data, $record): array
    {
        if (empty($data['gallery'])) {
            $data['gallery'] = $record->gallery ?? [];
        }

        return $data;
    }
}
