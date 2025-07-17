<!-- ✅ كارد موحد يحتوي جميع الفلاتر -->
<div class="bg-white shadow rounded-xl p-5 space-y-6">

    {{-- ✅ الفئات --}}
    <div>
        <h2 class="text-base font-semibold border-b pb-2 mb-3 text-gray-800 flex items-center gap-2">
            <i class="bi bi-layers text-blue-500"></i>
            تصفية حسب الفئات
        </h2>

        <ul class="space-y-2 text-sm text-gray-700">
            @if(isset($parentCategory))
                <li class="text-sm text-blue-700 font-semibold px-3 pb-1">
                    <i class="bi bi-folder"></i> {{ $parentCategory->name }}
                </li>
            @endif

            @if(!isset($parentCategory))
                <li>
                    <a wire:click.prevent="$set('selectedCategory', null)"
                       href="#"
                       class="block px-3 py-1 rounded-md transition
                       {{ is_null($selectedCategory) ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                        <i class="bi bi-sliders2-vertical me-1"></i> كل الفئات
                    </a>
                </li>
            @endif

            @if(isset($parentCategory))
                @foreach($categories as $child)
                    <li>
                        <a wire:click.prevent="$set('selectedCategory', {{ $child->id }})"
                           href="#"
                           class="block px-3 py-1 rounded-md transition
                           {{ $selectedCategory == $child->id ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
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
                                            class="px-2 py-1 rounded text-xs
                                            {{ $selectedCategory == $category->id ? 'bg-blue-600 text-white' : 'bg-blue-50 text-blue-600 hover:bg-blue-100' }}"
                                            title="تحديد هذه الفئة">
                                        <i class="bi bi-check-circle{{ $selectedCategory == $category->id ? '-fill' : '' }}"></i>
                                    </button>

                                    <button @click="open = !open"
                                            class="flex-1 flex items-center justify-between px-2 py-1 rounded-md bg-gray-100 text-blue-600 font-medium hover:bg-blue-50 transition ms-2">
                                        <span>{{ $category->name }}</span>
                                        <span class="flex items-center gap-1 text-xs">
                                            ({{ $children->count() }})
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
                                               {{ $selectedCategory == $child->id ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                                                – {{ $child->name }}
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
    <div>
        <h2 class="text-base font-semibold border-b pb-2 mb-3 text-gray-800 flex items-center gap-2">
            <i class="bi bi-geo-alt-fill text-red-500"></i>
            تصفية حسب المحافظات
        </h2>

        <div class="flex flex-wrap gap-2">
            <button
                wire:click="$set('selectedGovernorate', null)"
                class="px-3 py-1 text-sm rounded-full border transition
                    {{ is_null($selectedGovernorate)
                        ? 'bg-red-500 text-white border-red-500'
                        : 'bg-gray-100 text-gray-700 hover:bg-red-50 hover:text-red-600 border-gray-200' }}">
                الكل
            </button>

            @foreach($governorates as $gov)
                <button
                    wire:click="$set('selectedGovernorate', {{ $gov->id }})"
                    class="px-3 py-1 text-sm rounded-full border transition
                        {{ $selectedGovernorate == $gov->id
                            ? 'bg-red-500 text-white border-red-500'
                            : 'bg-gray-100 text-gray-700 hover:bg-red-50 hover:text-red-600 border-gray-200' }}">
                    {{ $gov->name }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- ✅ التقييمات --}}
    <div>
        <h2 class="text-base font-semibold border-b pb-2 mb-3 text-gray-800">
            <i class="bi bi-star-fill text-yellow-500 me-1"></i> تصفية حسب التقييمات
        </h2>

        <ul class="space-y-2 text-sm">
            @for($i = 5; $i >= 0; $i--)
                <li>
                    <label class="flex items-center gap-2 px-2 py-1 rounded cursor-pointer
                        {{ $ratingFilter === $i ? 'bg-yellow-50 text-yellow-700 font-semibold' : '' }}">
                        <input type="radio"
                               name="rating"
                               wire:click="$set('ratingFilter', {{ $i }})"
                               class="form-radio text-blue-600">

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
    <div class="text-center pt-2 border-t">
        <button wire:click="resetFilters"
            class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 text-sm font-medium rounded hover:bg-red-100 transition mt-4">
            <i class="bi bi-x-circle-fill text-base"></i>
            إعادة تعيين كل الفلاتر
        </button>
    </div>

</div>
