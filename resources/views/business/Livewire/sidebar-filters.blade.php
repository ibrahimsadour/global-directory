@props([
    'categories',
    'governorates',
    'locations' => collect(),
    'selectedCategory' => null,
    'selectedGovernorate' => null,
    'selectedLocation' => null,
    'ratingFilter' => null,
    'parentCategory' => null,
])

<!-- ✅ كارد موحد يحتوي جميع الفلاتر -->
<div class="bg-white shadow-md rounded-2xl p-5 space-y-6">

    {{-- ✅ الفئات --}}
    <div class="space-y-3 pb-4 border-b">
        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i class="bi bi-layers text-blue-500 text-xl"></i>
            تصفية حسب الفئات
        </h2>
        {{-- محتوى الفئات --}}
        <ul class="space-y-2 text-sm text-gray-700">
            {{-- الفئة الرئيسية --}}
            @if(isset($parentCategory))
                <li class="text-sm text-blue-700 font-semibold px-3 pb-1">
                    <i class="bi bi-folder"></i> {{ $parentCategory->name }}
                </li>
            @endif

            {{-- كل الفئات --}}
            @if(!isset($parentCategory))
                <li>
                    <a wire:click.prevent="$set('selectedCategory', null)"
                       href="#"
                       class="block px-3 py-1 rounded-md transition font-medium
                       {{ is_null($selectedCategory) ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                        <i class="bi bi-sliders2-vertical me-1"></i> كل الفئات
                    </a>
                </li>
            @endif

            {{-- الفئات الفرعية --}}
            @if(isset($parentCategory))
                @foreach($categories as $child)
                    <li>
                        <a wire:click.prevent="$set('selectedCategory', {{ $child->id }})"
                           href="#"
                           class="block px-3 py-1 rounded-md transition
                           {{ $selectedCategory == $child->id ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                            – {{ $child->name }}
                        </a>
                    </li>
                @endforeach
            @else
                @foreach($categories as $category)
                    @if(is_null($category->parent_id) && $category->is_active)
                        @php $children = $category->children->where('is_active', 1); @endphp
                        <li>
                            <div x-data="{ open: false }" class="space-y-1">
                                <div class="flex items-center justify-between">
                                    <button wire:click.prevent="$set('selectedCategory', {{ $category->id }})"
                                            class="px-2 py-1 rounded text-xs transition
                                            {{ $selectedCategory == $category->id ? 'bg-blue-600 text-white shadow' : 'bg-blue-50 text-blue-600 hover:bg-blue-100' }}"
                                            title="تحديد هذه الفئة">
                                        <i class="bi bi-check-circle{{ $selectedCategory == $category->id ? '-fill' : '' }}"></i>
                                    </button>

                                    <button @click="open = !open"
                                            class="flex-1 flex items-center justify-between px-2 py-1 rounded-md bg-gray-100 text-blue-600 font-medium hover:bg-blue-50 transition ms-2">
                                        <span>{{ $category->name }}</span>
                                        <span class="flex items-center gap-1 text-xs">
                                            ({{ $category->businesses_count + $children->sum('businesses_count') }})
                                            <i :class="open ? 'bi bi-chevron-up' : 'bi bi-chevron-down'"></i>
                                        </span>
                                    </button>
                                </div>

                                <ul x-show="open" x-transition x-cloak class="ps-4 pt-2 space-y-1">
                                    @foreach($children as $child)
                                        <li>
                                            <a wire:click.prevent="$set('selectedCategory', {{ $child->id }})"
                                               @click="open = false"
                                               href="#"
                                               class="block px-3 py-1 rounded-md transition
                                               {{ $selectedCategory == $child->id ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                                                – {{ $child->name }} ({{ $child->businesses_count }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>

    {{-- ✅ المحافظات --}}
    <div class="space-y-3 pb-4 border-b">
        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i class="bi bi-geo-alt-fill text-red-500 text-xl"></i>
            تصفية حسب المحافظات
        </h2>
        <div class="flex flex-wrap gap-2">
            <button
                wire:click="$set('selectedGovernorate', null)"
                class="px-3 py-1 text-sm rounded-full border font-medium transition
                    {{ is_null($selectedGovernorate)
                        ? 'bg-red-500 text-white border-red-500 shadow'
                        : 'bg-gray-100 text-gray-700 hover:bg-red-50 hover:text-red-600 border-gray-200' }}">
                الكل
            </button>
            @foreach($governorates as $gov)
                <button
                    wire:click="$set('selectedGovernorate', {{ $gov->id }})"
                    class="px-3 py-1 text-sm rounded-full border transition
                        {{ $selectedGovernorate == $gov->id
                            ? 'bg-red-500 text-white border-red-500 shadow'
                            : 'bg-gray-100 text-gray-700 hover:bg-red-50 hover:text-red-600 border-gray-200' }}">
                    {{ $gov->name }}
                    @if($selectedGovernorate == $gov->id)
                        <i class="bi bi-check2-circle ml-1"></i>
                    @endif
                </button>
            @endforeach
        </div>
    </div>

    {{-- ✅ المدن --}}
    <div class="space-y-3 pb-4 border-b">
        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i class="bi bi-building text-green-500 text-xl"></i>
            تصفية حسب المدن
        </h2>
        @if(empty($selectedGovernorate))
            <p class="text-gray-500 text-sm italic">يرجى اختيار محافظة لعرض المدن.</p>
        @else
            <div class="flex flex-wrap gap-2">
                <button
                    wire:click="$set('selectedLocation', null)"
                    class="px-3 py-1 text-sm rounded-full border font-medium transition
                        {{ is_null($selectedLocation)
                            ? 'bg-green-500 text-white border-green-500 shadow'
                            : 'bg-gray-100 text-gray-700 hover:bg-green-50 hover:text-green-600 border-gray-200' }}">
                    الكل
                    @if(is_null($selectedLocation))
                        <i class="bi bi-check2-circle ml-1"></i>
                    @endif
                </button>
                @forelse($locations as $loc)
                    <button
                        wire:click="$set('selectedLocation', {{ $loc->id }})"
                        class="px-3 py-1 text-sm rounded-full border transition
                            {{ $selectedLocation == $loc->id
                                ? 'bg-green-500 text-white border-green-500 shadow'
                                : 'bg-gray-100 text-gray-700 hover:bg-green-50 hover:text-green-600 border-gray-200' }}">
                        {{ $loc->area }}
                        @if($selectedLocation == $loc->id)
                            <i class="bi bi-check2-circle ml-1"></i>
                        @endif
                    </button>
                @empty
                    <span class="text-gray-400 text-sm">لا توجد مدن متاحة لهذه المحافظة</span>
                @endforelse
            </div>
        @endif
    </div>

    {{-- ✅ التقييمات --}}
    <div class="space-y-3 pb-4 border-b">
        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i class="bi bi-star-fill text-yellow-500 text-xl"></i>
            تصفية حسب التقييمات
        </h2>
        <ul class="space-y-2 text-sm">
            @for($i = 5; $i >= 0; $i--)
                <li>
                    <label class="flex items-center gap-2 px-2 py-1 rounded cursor-pointer transition
                        {{ $ratingFilter === $i ? 'bg-yellow-50 text-yellow-700 font-semibold shadow-sm' : 'hover:bg-yellow-50' }}">
                        <input type="radio"
                               name="rating"
                               wire:click="$set('ratingFilter', {{ $i }})"
                               class="form-radio text-blue-600 focus:ring-0">
                        <div class="flex text-yellow-400">
                            @for($j = 0; $j < 5; $j++)
                                <i class="bi {{ $j < $i ? 'bi-star-fill' : 'bi-star' }}"></i>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500">
                            @if($i === 5) ممتاز
                            @elseif($i === 4) جيد جدًا
                            @elseif($i === 3) جيد
                            @elseif($i === 2) مقبول
                            @elseif($i === 1) ضعيف
                            @else الكل
                            @endif
                        </span>
                    </label>
                </li>
            @endfor
        </ul>
    </div>

    {{-- ✅ زر إعادة تعيين الفلاتر --}}
    <div class="text-center pt-3">
        <button wire:click="resetFilters"
            class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 text-sm font-medium rounded hover:bg-red-100 transition mt-4 shadow-sm">
            <i class="bi bi-x-circle-fill text-base"></i>
            إعادة تعيين كل الفلاتر
        </button>
    </div>
</div>
