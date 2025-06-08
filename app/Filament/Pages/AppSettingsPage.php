<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Pages\Page;

class AppSettingsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'Settings';
    protected static bool $isLivewire = true;
    protected static string $view = 'filament.pages.app-settings-page';

    public $settings = [];

    public function mount(): void
    {
        $this->settings = Setting::where('group', 'app')->pluck('value', 'key')->toArray();
    }

    public function save()
    {
        foreach ($this->settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key, 'group' => 'app'],
                ['value' => $value]
            );
        }

        session()->flash('success', 'تم حفظ إعدادات التطبيق بنجاح!');
    }
}