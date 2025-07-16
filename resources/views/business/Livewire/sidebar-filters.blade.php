    <!-- ✅ الفئات -->
    <div class="bg-white shadow rounded-lg p-4">
        <h2 class="text-base font-semibold border-b pb-2 mb-3 text-gray-800 flex items-center gap-2">
            <i class="bi bi-layers text-blue-500"></i>
            تصفية حسب الفئات
        </h2>

        <ul class="space-y-2 text-sm text-gray-700">
            <!-- ✅ خيار "كل الفئات" -->
            <li>
                <a wire:click.prevent="$set('selectedCategory', null)"
                href="#"
                class="block px-3 py-1 rounded-md transition
                    @if(is_null($selectedCategory))
                            {{ is_null($selectedCategory) ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 hover:text-blue-600 text-gray-700' }}">
                        <i class="bi bi-sliders2-vertical me-1"></i> كل الفئات
                    @endif

                </a>
            </li>

            <!-- ✅ الفئات الرئيسية -->
            @foreach($categories as $category)
                @if(is_null($category->parent_id) && $category->is_active)
                    <li>
                        @if($category->children && $category->children->where('is_active', 1)->count())
                            <div x-data="{ open: false }" class="space-y-1">
                                <button @click="open = !open"
                                        class="w-full flex items-center justify-between px-2 py-1 rounded-md bg-gray-100 text-blue-600 font-medium hover:bg-blue-50 transition">
                                    <span>{{ $category->name }}</span>
                                    <span class="flex items-center gap-1">
                                        ({{ $category->children->where('is_active', 1)->count() }})
                                        <i :class="open ? 'bi bi-chevron-up' : 'bi bi-chevron-down'" class="text-xs"></i>
                                    </span>
                                </button>

                                <ul x-show="open" x-transition x-cloak class="ps-4 pt-2 space-y-1">
                                    @foreach($category->children->where('is_active', 1) as $child)
                                        <li>
                                            <a wire:click.prevent="$set('selectedCategory', {{ $child->id }})"
                                            @click="open = false"
                                            href="#"
                                            class="block px-3 py-1 rounded-md transition
                                                    {{ $selectedCategory == $child->id
                                                        ? 'bg-blue-100 text-blue-700 font-semibold'
                                                        : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                                                – {{ $child->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <a wire:click.prevent="$set('selectedCategory', {{ $category->id }})"
                            href="#"
                            class="block px-3 py-1 rounded-md transition
                                    {{ $selectedCategory == $category->id
                                        ? 'bg-blue-100 text-blue-700 font-semibold'
                                        : 'text-gray-800 hover:bg-blue-50 hover:text-blue-600' }}">
                                {{ $category->name }}
                            </a>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </div>


    <!-- ✅ المحافظات -->
    <div class="bg-white shadow rounded-lg p-4">
        <h2 class="text-base font-semibold border-b pb-2 mb-3 text-gray-800 flex items-center gap-2">
            <i class="bi bi-geo-alt-fill text-red-500"></i>
            تصفية حسب المحافظات
        </h2>

        <div class="flex flex-wrap gap-2">
            <!-- ✅ خيار "الكل" -->
            <button
                wire:click="$set('selectedGovernorate', null)"
                class="px-3 py-1 text-sm rounded-full border transition
                    {{ is_null($selectedGovernorate)
                            ? 'bg-red-500 text-white border-red-500'
                            : 'bg-gray-100 text-gray-700 hover:bg-red-50 hover:text-red-600 border-gray-200' }}">
                الكل
            </button>

            <!-- ✅ المحافظات الفعالة -->
            @foreach($governorates as $gov)
                <button
                    wire:click="$set('selectedGovernorate', '{{ $gov->id }}')"
                    class="px-3 py-1 text-sm rounded-full border transition
                        {{ $selectedGovernorate == $gov->id
                                ? 'bg-red-500 text-white border-red-500'
                                : 'bg-gray-100 text-gray-700 hover:bg-red-50 hover:text-red-600 border-gray-200' }}">
                    {{ $gov->name }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- ✅ التقييم -->
    <div class="bg-white shadow rounded-lg p-4">
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

    <!-- ✅ زر إعادة تعيين الفلاتر بشكل بارز -->
    <div class="text-center mt-6">
        <button wire:click="resetFilters"
            class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 text-sm font-medium rounded hover:bg-red-100 transition">
            <i class="bi bi-x-circle-fill text-base"></i>
            إعادة تعيين كل الفلاتر
        </button>
    </div>