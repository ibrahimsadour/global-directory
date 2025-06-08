<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Pages\Page;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class SiteSettingsPage extends Page
{
    use WithFileUploads;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Settings';
    protected static bool $isLivewire = true;
    protected static string $view = 'filament.pages.site-settings-page';

    public $settings = [];

    // خصائص الملفات للصور
    public $site_logo_file;
    public $site_favicon_file;
    public $site_home_banner_file;

    public function mount(): void
    {
        $this->settings = Setting::where('group', 'site')->pluck('value', 'key')->toArray();
    }

    public function save()
    {
        // شعار الموقع
        if ($this->site_logo_file) {
            // حذف الصورة القديمة إذا كانت موجودة
            $oldLogo = $this->settings['site_logo'] ?? null;
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            // تجهيز الاسم الجديد وحفظ الصورة الجديدة
            $originalName = str_replace(' ', '-', $this->site_logo_file->getClientOriginalName());
            $logoPath = $this->site_logo_file->storeAs('site-settings', $originalName, 'public');
            Setting::updateOrCreate(
                ['key' => 'site_logo', 'group' => 'site'],
                ['value' => $logoPath]
            );
            $this->settings['site_logo'] = $logoPath;
            $this->site_logo_file = null;
        }

        if ($this->site_favicon_file) {
            $oldFavicon = $this->settings['site_favicon'] ?? null;
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }

            $originalName = str_replace(' ', '-', $this->site_favicon_file->getClientOriginalName());
            $faviconPath = $this->site_favicon_file->storeAs('site-settings', $originalName, 'public');
            Setting::updateOrCreate(
                ['key' => 'site_favicon', 'group' => 'site'],
                ['value' => $faviconPath]
            );
            $this->settings['site_favicon'] = $faviconPath;
            $this->site_favicon_file = null;
        }

        if ($this->site_home_banner_file) {
            $oldBanner = $this->settings['site_home_banner'] ?? null;
            if ($oldBanner && Storage::disk('public')->exists($oldBanner)) {
                Storage::disk('public')->delete($oldBanner);
            }

            $originalName = str_replace(' ', '-', $this->site_home_banner_file->getClientOriginalName());
            $bannerPath = $this->site_home_banner_file->storeAs('site-settings', $originalName, 'public');
            Setting::updateOrCreate(
                ['key' => 'site_home_banner', 'group' => 'site'],
                ['value' => $bannerPath]
            );
            $this->settings['site_home_banner'] = $bannerPath;
            $this->site_home_banner_file = null;
        }

        // الحقول النصية وباقي الحقول
        foreach ($this->settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key, 'group' => 'site'],
                ['value' => $value]
            );
        }

        session()->flash('success', 'تم حفظ إعدادات الموقع بنجاح!');
    }
}
