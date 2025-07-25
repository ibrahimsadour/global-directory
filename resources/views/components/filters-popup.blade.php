@props([
    'categories',
    'governorates',
    'selectedCategory' => null,
    'selectedGovernorate' => null,
    'selectedLocation' => null,
    'ratingFilter' => null,
    'parentCategory' => null,

])
<div x-data="{ openFilters: false }">
    <!-- زر تصفية للموبايل -->
    <div class="md:hidden mb-4 flex justify-end">
        <button @click="openFilters = true" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm rounded shadow">
            <i class="bi bi-sliders"></i> تصفية
        </button>
    </div>

    <!-- الشبكة الرئيسية -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- الشريط الجانبي (ديسكتوب) -->
        <aside class="md:col-span-1 space-y-6 hidden md:block">
            @include('business.Livewire.sidebar-filters', [
                'categories' => $categories,
                'governorates' => $governorates,
                'selectedCategory' => $selectedCategory,
                'selectedGovernorate' => $selectedGovernorate,
                'selectedLocation' => $selectedLocation, // ← أضفنا هذا
                'ratingFilter' => $ratingFilter,
                'parentCategory' => $parentCategory,
            ])

        </aside>

        <!-- المحتوى الرئيسي -->
        <section class="md:col-span-3">
            {{ $slot }}
        </section>
    </div>

    <!-- نافذة الفلاتر (موبايل) -->
    <div x-show="openFilters"
        x-cloak
        x-transition
        class="fixed inset-0 bg-black/50 z-[999] flex items-center justify-center md:hidden">
        
        <div class="bg-white w-full max-w-md max-h-[90vh] overflow-y-auto rounded-2xl p-4 shadow-2xl relative mx-auto">
            <button @click="openFilters = false"
                    class="absolute top-3 right-3 bg-white border border-gray-300 rounded-full p-1 text-gray-600 hover:text-red-600 shadow-md z-50">
                <i class="bi bi-x-lg text-lg"></i>
            </button>

            {{-- ✅ تضمين الفلاتر --}}
            @include('business.Livewire.sidebar-filters', [
                'categories' => $categories,
                'governorates' => $governorates,
                'selectedCategory' => $selectedCategory,
                'selectedGovernorate' => $selectedGovernorate,
                'selectedLocation' => $selectedLocation,
                'ratingFilter' => $ratingFilter,
                'parentCategory' => $parentCategory // ← هنا الجديد

            ])
            {{-- ✅ زر "عرض النتائج" أسفل الفلاتر --}}
            <div class="mt-6 text-center">
                <button @click="openFilters = false; window.scrollTo({ top: 0, behavior: 'smooth' })"
                        class="inline-flex items-center justify-center gap-2 px-6 py-2 bg-blue-600 text-white rounded-md text-sm shadow hover:bg-blue-700 transition">
                    <i class="bi bi-eye-fill"></i>
                    عرض النتائج
                </button>
            </div>

        </div>
    </div>

</div>
