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

        <!-- اسم التطبيق -->
        <div class="bg-white p-6 rounded-lg shadow border mb-6">
            <h2 class="text-lg font-bold mb-4">اسم التطبيق (App Name)</h2>
            <input type="text" wire:model.defer="settings.app_name" placeholder="App Name" class="border border-gray-300 rounded p-2 w-full">
        </div>

        <!-- وضع الصيانة -->
        <div class="bg-white p-6 rounded-lg shadow border mb-6">
            <h2 class="text-lg font-bold mb-4">وضع الصيانة (Maintenance Mode)</h2>
            <select wire:model.defer="settings.maintenance_mode" class="border border-gray-300 rounded p-2 w-full">
                <option value="0">إيقاف (Off)</option>
                <option value="1">تشغيل (On)</option>
            </select>
            <p class="text-xs text-gray-500 mt-2">عند التفعيل، سيظهر الموقع في وضع الصيانة.</p>
        </div>

        <!-- رسالة الصيانة -->
        <div class="bg-white p-6 rounded-lg shadow border col-span-1 md:col-span-2 mb-6">
            <h2 class="text-lg font-bold mb-4">رسالة الصيانة (Maintenance Message)</h2>
            <input type="text" wire:model.defer="settings.app_maintenance_message" placeholder="Maintenance Message" class="border border-gray-300 rounded p-2 w-full">
        </div>

        <!-- كود برمجي مخصص -->
        <div class="bg-white p-6 rounded-lg shadow border col-span-1 md:col-span-2 mb-6">
            <h2 class="text-lg font-bold mb-4">كود برمجي مخصص (Code Snippet)</h2>
            <textarea wire:model.defer="settings.code_snippet" placeholder="ضع كود تتبع أو جافاسكريبت هنا" class="border border-gray-300 rounded p-2 w-full" rows="6"></textarea>
            <p class="text-xs text-gray-500 mt-2">استخدم هذا الحقل لإضافة أكواد تتبع أو جافاسكريبت مخصصة لكل صفحات الموقع.</p>
        </div>

        <!-- زر الحفظ -->
        <div class="col-span-1 md:col-span-2 flex justify-end mb-4">
            <x-filament::button type="submit" color="primary" wire:loading.attr="disabled">
                <span wire:loading.remove>حفظ إعدادات التطبيق</span>
                <span wire:loading>جاري الحفظ...</span>
            </x-filament::button>
        </div>

    </form>
</x-filament::page>
