<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Models\Business;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class DownloadGoogleImages extends Command
{
    protected $signature = 'business:download-images';
    protected $description = 'Download Google Place images and save them locally as .webp files in from-google folder';

    public function handle(): int
    {
        $this->info("🔍 جاري تحميل الصور من Google وحفظها بصيغة WebP...");

        $manager = new ImageManager(new Driver());

        $businesses = Business::where('image', 'like', '%maps.googleapis.com%')
            ->whereNotNull('place_id')
            ->get();

        $total = $businesses->count();
        $success = 0;
        $failures = [];

        foreach ($businesses as $business) {
            $url = $business->image;
            $placeId = $business->place_id;
            $filename = 'business-images/from-google/' . $placeId . '.webp';

            if (Storage::disk('public')->exists($filename)) {
                $this->line("⏩ موجود مسبقًا: {$business->name}");
                continue;
            }

            try {
                $response = Http::timeout(10)->get($url);

                if (!$response->successful() || strlen($response->body()) < 5000) {
                    $this->warn("⚠️ فشل تحميل أو صورة صغيرة جداً: {$business->name}");
                    $failures[] = $business->id;
                    continue;
                }

                $webpImage = $manager->read($response->body())->toWebp();
                Storage::disk('public')->put($filename, $webpImage);

                $business->update([
                    'image' => $filename,
                ]);

                $this->info("✅ تم حفظ الصورة بصيغة WebP: {$business->name}");
                $success++;

                usleep(300000);

            } catch (\Exception $e) {
                $this->error("❌ خطأ في {$business->name}: " . $e->getMessage());
                $failures[] = $business->id;
            }
        }

        $this->newLine();
        $this->info("📊 النتائج:");
        $this->info("✔️ تم تحميل: {$success} من {$total}");
        $this->warn("❌ فشل تحميل: " . count($failures));

        return Command::SUCCESS;
    }
}
