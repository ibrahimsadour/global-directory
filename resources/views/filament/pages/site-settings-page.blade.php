<x-filament::page>
    @if (session()->has('success'))
        <div class="flex items-center p-4 mb-4 text-green-800 bg-gradient-to-r from-green-100 via-green-50 to-green-100 border border-green-300 rounded-lg shadow" role="alert">
            <span class="sr-only">Success</span>
            <div class="text-base font-semibold text-green-800">
                ✅ تم الحفظ بنجاح!
                <div class="text-sm font-normal mt-1 text-green-700">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Site Logo -->
        <div class="bg-white p-6 rounded-lg shadow border mb-6">
            <h2 class="text-lg font-bold mb-4">Site Logo</h2>
            <input type="file" wire:model="site_logo_file">
            @if (!empty($settings['site_logo']))
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Site Logo" class="w-32 h-32 object-contain rounded">
                </div>
            @endif
        </div>

        <!-- Fav Icon -->
        <div class="bg-white p-6 rounded-lg shadow border mb-6">
            <h2 class="text-lg font-bold mb-4">Fav Icon</h2>
            <input type="file" wire:model="site_favicon_file">
            @if (!empty($settings['site_favicon']))
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Fav Icon" class="w-16 h-16 object-contain rounded">
                </div>
            @endif
        </div>

        <!-- Home banner -->
        <div class="bg-white p-6 rounded-lg shadow border mb-6">
            <h2 class="text-lg font-bold mb-4">Site home banner</h2>
            <input type="file" wire:model="site_home_banner_file">
            @if (!empty($settings['site_home_banner']))
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $settings['site_home_banner']) }}" alt="Site home banner" class="w-32 h-16 object-contain rounded">
                </div>
            @endif
        </div>

        <!-- Title Description -->
        <div class="bg-white p-6 rounded-lg shadow border col-span-1 md:col-span-2 mb-6">
            <h2 class="text-lg font-bold mb-4">Title Description</h2>
            <div class="space-y-4">
                <input type="text" wire:model.defer="settings.site_title" placeholder="Site Title" class="border border-gray-300 rounded p-2 w-full">
                <textarea wire:model.defer="settings.site_description" placeholder="Site Description" class="border border-gray-300 rounded p-2 w-full" rows="3"></textarea>
            </div>
        </div>

        <!-- Contact Details -->
        <div class="bg-white p-6 rounded-lg shadow border mb-6">
            <h2 class="text-lg font-bold mb-4">Contact Details</h2>
            <div class="space-y-4">
                <input type="text" wire:model.defer="settings.site_mobile" placeholder="Mobile Number" class="border border-gray-300 rounded p-2 w-full">
                <input type="text" wire:model.defer="settings.site_email" placeholder="Email Address" class="border border-gray-300 rounded p-2 w-full">
                <input type="text" wire:model.defer="settings.site_web_address" placeholder="Web Address" class="border border-gray-300 rounded p-2 w-full">
                <textarea wire:model.defer="settings.site_address" placeholder="Address" class="border border-gray-300 rounded p-2 w-full" rows="2"></textarea>
            </div>
        </div>

        <!-- Social Links -->
        <div class="bg-white p-6 rounded-lg shadow border mb-6">
            <h2 class="text-lg font-bold mb-4">Social Links</h2>
            <div class="space-y-4">
                <input type="text" wire:model.defer="settings.social_facebook" placeholder="Facebook" class="border border-gray-300 rounded p-2 w-full">
                <input type="text" wire:model.defer="settings.social_twitter" placeholder="Twitter" class="border border-gray-300 rounded p-2 w-full">
                <input type="text" wire:model.defer="settings.social_linkedin" placeholder="LinkedIn" class="border border-gray-300 rounded p-2 w-full">
                <input type="text" wire:model.defer="settings.social_instagram" placeholder="Instagram" class="border border-gray-300 rounded p-2 w-full">
                <input type="text" wire:model.defer="settings.social_youtube" placeholder="Youtube" class="border border-gray-300 rounded p-2 w-full">
                <input type="text" wire:model.defer="settings.social_pinterest" placeholder="Pinterest" class="border border-gray-300 rounded p-2 w-full">
            </div>
        </div>

        <!-- زر الحفظ الموحد -->
        <div class="col-span-1 md:col-span-2 flex justify-end mb-4">
            <x-filament::button type="submit" color="primary" wire:loading.attr="disabled">
                <span wire:loading.remove>حفظ جميع التغييرات</span>
                <span wire:loading>جاري الحفظ...</span>
            </x-filament::button>
        </div>

    </form>
</x-filament::page>
