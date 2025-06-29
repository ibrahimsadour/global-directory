<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Pages\Page;
use Livewire\WithFileUploads;

class SEOSettingsPage extends Page
{
    use WithFileUploads;

    protected static ?string $navigationGroup = '⚙️ الإعدادات';
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationLabel = 'اعدادات السيو';
    protected static bool $isLivewire = true;
    protected static string $view = 'filament.pages.seo-settings-page';

    public $settings = [];

    public function mount(): void
    {
        $this->settings = Setting::where('group', 'seo')->pluck('value', 'key')->toArray();
    }

    public function save()
    {
        foreach ($this->settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key, 'group' => 'seo'],
                ['value' => $value]
            );
        }

        session()->flash('success', 'تم حفظ إعدادات السيو بنجاح!');
    }
}
