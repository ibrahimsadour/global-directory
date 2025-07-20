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
                        @if (!empty($biz['photo_url'] ?? $biz['image']))
                            <div class="w-full h-[160px] overflow-hidden rounded-md border border-gray-300 shadow-sm">
                                <img 
                                    src="{{ $biz['photo_url'] ?? $biz['image'] }}" 
                                    alt="صورة النشاط"
                                    class="w-[100%] h-[160px] object-cover object-center" 
                                    style=" height: 400px; width: 100%; "
                                />
                            </div>
                        @else
                            <div class="w-full h-[160px] flex items-center justify-center text-gray-400 italic border border-dashed border-gray-300 rounded-md">
                                لا توجد صورة
                            </div>
                        @endif


                        {{-- المعلومات --}}
                        <h2 class="text-lg font-bold text-gray-800">{{ $biz['name'] ?? '—' }}</h2>

                        <p class="text-sm text-gray-700 flex items-center gap-1">
                            🏷️ <strong class="min-w-[80px] inline-block">العنوان:</strong> {{ $biz['address'] ?? '—' }}
                        </p>

                        <p class="text-sm text-gray-700 flex items-center gap-1">
                            📞 <strong class="min-w-[80px] inline-block">الهاتف:</strong> {{ $biz['phone'] ?? '—' }}
                        </p>

                        <p class="text-sm text-gray-700 flex items-center gap-1">
                            ⭐ <strong class="min-w-[80px] inline-block">التقييم:</strong> {{ $biz['rating'] ?? '—' }} ({{ $biz['reviews_count'] ?? 0 }} مراجعة)
                        </p>

                        <p class="text-xs text-gray-600 flex items-center gap-1">
                            🧭 <strong class="min-w-[80px] inline-block">الإحداثيات:</strong> {{ $biz['latitude'] ?? '—' }}, {{ $biz['longitude'] ?? '—' }}
                        </p>

                        <p class="text-xs text-gray-500 break-all flex items-center gap-1">
                            🆔 <strong class="min-w-[80px] inline-block">place_id:</strong> {{ $biz['place_id'] ?? '—' }}
                        </p>
                        
                        {{-- عرض اوقات الدوامم --}}
                        @if (!empty($business['opening_hours']))
                            <div class="text-sm text-gray-700">
                                <strong class="block mb-1">أوقات العمل:</strong>
                                <ul class="space-y-1 rtl:space-y-reverse">
                                    @foreach (explode(',', $business['opening_hours']) as $entry)
                                        @php
                                            $parts = explode(':', $entry, 2);
                                            $day = trim($parts[0] ?? '');
                                            $hours = trim($parts[1] ?? '', "[] ");
                                        @endphp

                                        @if ($day && $hours)
                                            <li><span class="font-semibold">{{ $day }}:</span> {{ $hours }}</li>
                                        @endif
                                    @endforeach
                                </ul>
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
