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

        <!-- Meta Title -->
        <div class="bg-white p-6 rounded-lg shadow border mb-6">
            <h2 class="text-lg font-bold mb-4">Meta Title</h2>
            <input type="text" wire:model.defer="settings.seo_meta_title" placeholder="Meta Title" class="border border-gray-300 rounded p-2 w-full">
        </div>

        <!-- Meta Keywords -->
        <div class="bg-white p-6 rounded-lg shadow border mb-6">
            <h2 class="text-lg font-bold mb-4">Meta Keywords</h2>
            <textarea wire:model.defer="settings.seo_meta_keywords" placeholder="Meta Keywords" class="border border-gray-300 rounded p-2 w-full" rows="2"></textarea>
        </div>

        <!-- Meta Description -->
        <div class="bg-white p-6 rounded-lg shadow border col-span-1 md:col-span-2 mb-6">
            <h2 class="text-lg font-bold mb-4">Meta Description</h2>
            <textarea wire:model.defer="settings.seo_meta_description" placeholder="Meta Description" class="border border-gray-300 rounded p-2 w-full" rows="3"></textarea>
        </div>
        
        <!-- Robots.txt -->
        <div class="bg-white p-6 rounded-lg shadow border col-span-1 md:col-span-2 mb-6">
            <h2 class="text-lg font-bold mb-4">robots.txt</h2>
            <textarea wire:model.defer="settings.seo_robots_txt" placeholder="robots.txt" class="border border-gray-300 rounded p-2 w-full" rows="6"></textarea>
            <p class="text-xs text-gray-500 mt-2">يمكنك هنا تعديل ملف robots.txt الذي يتحكم بأرشفة محركات البحث.</p>
        </div>
        <!-- زر الحفظ -->
        <div class="col-span-1 md:col-span-2 flex justify-end mb-4">
            <x-filament::button type="submit" color="primary" wire:loading.attr="disabled">
                <span wire:loading.remove>حفظ إعدادات السيو</span>
                <span wire:loading>جاري الحفظ...</span>
            </x-filament::button>
        </div>

    </form>
</x-filament::page>
