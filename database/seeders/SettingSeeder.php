<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [

            // الموقع
            ['group' => 'site', 'key' => 'site_logo', 'type' => 'image', 'value' => 'site-settings/logo.png'],
            ['group' => 'site', 'key' => 'site_home_banner', 'type' => 'image', 'value' => 'site-settings/home_banner.jpg'],
            ['group' => 'site', 'key' => 'site_favicon', 'type' => 'image', 'value' => 'site-settings/favicon.png'],

            ['group' => 'site', 'key' => 'site_title', 'type' => 'text', 'value' => 'دليلي المحلي في الكويت'],
            ['group' => 'site', 'key' => 'site_description', 'type' => 'textarea', 'value' => 'أفضل دليل محلي في الكويت يقدم جميع الخدمات بسهولة.'],
            ['group' => 'site', 'key' => 'site_mobile', 'type' => 'text', 'value' => '96512345678'],
            ['group' => 'site', 'key' => 'site_email', 'type' => 'email', 'value' => 'info@example.com'],
            ['group' => 'site', 'key' => 'site_web_address', 'type' => 'url', 'value' => 'https://example.com'],
            ['group' => 'site', 'key' => 'site_address', 'type' => 'textarea', 'value' => 'الكويت - شارع رئيسي - مجمع X'],

            // روابط التواصل
            ['group' => 'site', 'key' => 'social_facebook', 'type' => 'url', 'value' => 'https://facebook.com/example'],
            ['group' => 'site', 'key' => 'social_instagram', 'type' => 'url', 'value' => 'https://instagram.com/example'],
            ['group' => 'site', 'key' => 'social_twitter', 'type' => 'url', 'value' => 'https://twitter.com/example'],
            ['group' => 'site', 'key' => 'social_linkedin', 'type' => 'url', 'value' => 'https://linkedin.com/company/example'],
            ['group' => 'site', 'key' => 'social_youtube', 'type' => 'url', 'value' => 'https://youtube.com/example'],

            // الفوتر
            ['group' => 'site', 'key' => 'footer_copyright', 'type' => 'textarea', 'value' => '© 2025 جميع الحقوق محفوظة. دليلي المحلي'],
            
            // السيو
            ['group' => 'seo', 'key' => 'seo_meta_title', 'type' => 'text', 'value' => 'دليلي المحلي - أفضل دليل خدمات في الكويت'],
            ['group' => 'seo', 'key' => 'seo_meta_description', 'type' => 'textarea', 'value' => 'أفضل موقع دليل محلي يقدم خدمات متنوعة في جميع مناطق الكويت.'],
            ['group' => 'seo', 'key' => 'seo_meta_keywords', 'type' => 'textarea', 'value' => 'دليل, خدمات, الكويت, تنظيف, تكييف, كهربائي'],
            ['group' => 'seo', 'key' => 'seo_robots_txt', 'type' => 'textarea', 'value' => "User-agent: *\nDisallow:"],


            // إعدادات التطبيق
            ['group' => 'app', 'key' => 'app_name', 'type' => 'text', 'value' => 'Global directory'],
            ['group' => 'app', 'key' => 'maintenance_mode', 'type' => 'boolean', 'value' => false],
            ['group' => 'app', 'key' => 'app_maintenance_message', 'type' => 'text', 'value' => 'Maintenance Message'],
            ['group' => 'app', 'key' => 'code_snippet', 'type' => 'textarea', 'value' => ''],





        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
