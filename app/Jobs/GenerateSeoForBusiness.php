<?php

namespace App\Jobs;

use App\Models\Business;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateSeoForBusiness implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Business $business;

    /**
     * Create a new job instance.
     */
    public function __construct(Business $business)
    {
        $this->business = $business;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $name = $this->business->name;
            $categoryId = $this->business->category_id;
            $governorateId = $this->business->governorate_id;
            $phone = $this->business->phone;

            // وصف + بيانات سيو
            $description = generateBusinessDescription($name, $categoryId, $governorateId, $phone);
            $seo = generateBusinessSeo($name, $categoryId, $governorateId);

            // تحديث البيانات في جدول النشاطات
            $this->business->update([
                'description' => $description,
            ]);

            // تحديث أو إنشاء سجل السيو
            $this->business->seo()->updateOrCreate([], [
                'meta_title' => $seo['meta_title'],
                'meta_description' => $seo['meta_description'],
                'meta_keywords' => $seo['meta_keywords'],
            ]);

        } catch (\Exception $e) {
            Log::error("فشل Job توليد السيو للنشاط {$this->business->id}: " . $e->getMessage());
        }
    }
}
