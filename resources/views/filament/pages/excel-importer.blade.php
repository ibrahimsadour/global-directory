{{-- ... بداية الصفحة --}}
<x-filament::page>
    {{ $this->form }}

    <div class="mt-6">
        <x-filament::button wire:click="processImport" color="primary">
            استيراد النشاطات من Excel
        </x-filament::button>
    </div>

    {{-- عرض النتائج --}}
    @if ($previewBusinesses->isNotEmpty())
        <div class="mt-10">
            <h2 class="text-xl font-bold text-gray-800 mb-4">📝 النتائج المقترحة للاستيراد:</h2>

            {{-- معلومات الفلترة --}}
            <div class="bg-gray-50 border border-gray-200 p-4 rounded-md text-sm text-gray-700 mb-6">
                <div class="flex flex-wrap gap-4">
                    <div>🏛️ <strong>المحافظة:</strong> {{ $governorateName }}</div>
                    <div>🏙️ <strong>المدينة:</strong> {{ $locationName }}</div>
                    <div>🏷️ <strong>التصنيف:</strong> {{ $categoryName }}</div>
                </div>
            </div>

            {{-- زر حفظ الكل --}}
            <div class="mb-4">
                <x-filament::button color="success" wire:click="saveBusinesses">
                    ✅ حفظ جميع الأنشطة
                </x-filament::button>
            </div>

            {{-- عرض البطاقات --}}
            <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-3 gap-6 mt-6">
                @foreach ($previewBusinesses as $biz)
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden p-4 flex flex-col gap-3">
                    {{-- الصورة --}}
                    @php
                        $rawImage = $biz['photo_url'] ?? $biz['image'] ?? null;
                        $hasImage = !empty($rawImage) && !Str::contains($rawImage, 'default');
                        $image = $hasImage ? $rawImage : 'storage/business_photos/default.webp';
                    @endphp

                    <div class="w-full h-[160px] overflow-hidden rounded-md border border-gray-300 shadow-sm">
                        <img 
                            src="{{ asset($image) }}" 
                            alt="{{ $biz['name'] ?? '—' }}" 
                            class="w-full h-[160px] object-cover object-center"
                        />
                    </div>



                        {{-- المعلومات --}}
                        <h2 class="text-lg font-bold text-gray-800">{{ $biz['name'] ?? '—' }}</h2>

                        <p class="text-sm text-gray-700 flex items-center gap-1">
                            🏷️ <strong class="min-w-[80px] inline-block">العنوان:</strong> {{ $biz['address'] ?? '—' }}
                        </p>

                        <p class="text-sm text-gray-700 flex items-center gap-1">
                            📞 <strong class="min-w-[80px] inline-block">الهاتف:</strong> {{ $biz['phone'] ?? '—' }}
                        </p>

                        <p class="text-xs text-gray-600 flex items-center gap-1">
                            🧭 <strong class="min-w-[80px] inline-block">الإحداثيات:</strong> {{ $biz['latitude'] ?? '—' }}, {{ $biz['longitude'] ?? '—' }}
                        </p>

                        <p class="text-xs text-gray-500 break-all flex items-center gap-1">
                            🆔 <strong class="min-w-[80px] inline-block">place_id:</strong> {{ $biz['place_id'] ?? '—' }}
                        </p>

                {{-- أوقات الدوام --}}
                @if (!empty($biz['opening_hours']) && is_string($biz['opening_hours']))
                    <div class="text-sm text-gray-700">
                        <strong class="block mb-1">🕒 أوقات العمل:</strong>
                        <ul class="space-y-1 rtl:space-y-reverse">
                            @foreach (explode(',', $biz['opening_hours']) as $entry)
                                @php
                                    // التعبير المنتظم المعدل: يدعم الأقواس المربعة الاختيارية
                                    // يلتقط اليوم (matches[1]) ونطاق الوقت/الإغلاق (matches[2])
                                    // مثال1: الاثنين:[٧:٣٠ص-١١:٠٠م]
                                    // مثال2: الاثنين:٨:٣٠ص–٢:١٠م
                                    preg_match('/^(.+?):(?:\[?(.+?)\]?)$/u', trim($entry), $matches);
                                    
                                    $day = $matches[1] ?? null;
                                    $hours = $matches[2] ?? null;

                                    // تنظيف وإعادة تنسيق حالة 'مغلق' أو 'Closed'
                                    if ($hours) {
                                        $hours = trim($hours);
                                        // التعامل مع حالة الإغلاق (قد تحتاج إلى إضافة المزيد من الكلمات مثل Closed أو مغلق)
                                        if (in_array(strtolower($hours), ['مغلق', 'closed', 'no opening hours'])) {
                                            $displayHours = '<span class="text-red-600 font-semibold">مغلق</span>';
                                        } else {
                                            // يتم عرض الساعات كما هي إذا كانت موجودة
                                            $displayHours = $hours;
                                        }
                                    }
                                @endphp

                                @if ($day && isset($displayHours))
                                    <li><span class="font-semibold">{{ $day }}:</span> {!! $displayHours !!}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif

                        {{-- بيانات Google الإضافية --}}
                        @if (!empty($biz['google_maps_url']) || !empty($biz['google_reviews_url']) || !empty($biz['google_rating']))
                            <div class="text-sm text-gray-600 border-t pt-2 mt-2">
                                <strong class="block mb-1 text-gray-800">🌐 بيانات Google:</strong>
                                
                                @if (!empty($biz['google_maps_url']))
                                    <p class="text-xs text-blue-600">
                                        📍 <a href="{{ $biz['google_maps_url'] }}" target="_blank" class="underline">رابط الموقع على Google Maps</a>
                                    </p>
                                @endif

                                @if (!empty($biz['google_reviews_url']))
                                    <p class="text-xs text-blue-600">
                                        📝 <a href="{{ $biz['google_reviews_url'] }}" target="_blank" class="underline">عرض التقييمات على Google</a>
                                    </p>
                                @endif

                                @if (!empty($biz['google_rating']) || !empty($biz['google_reviews_count']))
                                    <p class="text-xs text-gray-700">
                                        ⭐ تقييم Google: {{ $biz['google_rating'] ?? '—' }} ({{ $biz['google_reviews_count'] ?? 0 }} مراجعة)
                                    </p>
                                @endif
                            </div>
                        @endif

                        {{-- زر الحفظ الفردي --}}
                        <div class="mt-2">
                            @if (!empty($biz['place_id']) && in_array($biz['place_id'], $savedPlaces ?? []))
                                <span class="text-green-600 font-semibold text-sm flex items-center gap-1">
                                    ✅ تم الحفظ
                                </span>
                            @else
                                <x-filament::button 
                                    wire:click="saveSingleBusiness('{{ $biz['place_id'] }}')" 
                                    wire:loading.attr="disabled"
                                    wire:target="saveSingleBusiness('{{ $biz['place_id'] }}')"
                                    size="sm" 
                                    color="success" 
                                    icon="heroicon-o-check-circle"
                                >
                                    حفظ هذا النشاط
                                </x-filament::button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</x-filament::page>
