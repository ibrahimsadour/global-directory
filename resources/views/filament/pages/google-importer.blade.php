<x-filament::page>
    {{-- النموذج --}}
    <form wire:submit.prevent="fetchFromGoogle" class="space-y-6">
        {{ $this->form }}
        <x-filament::button type="submit">
            جلب الأنشطة من Google
        </x-filament::button>
    </form>

    {{-- مؤشر تحميل أثناء جلب البيانات --}}
    <div wire:loading wire:target="fetchFromGoogle" class="flex items-center gap-2 mt-4 text-primary-600">
        <svg class="animate-spin h-5 w-5 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
        </svg>
        <span>جاري جلب البيانات من Google، يرجى الانتظار...</span>
    </div>

    {{-- زر حفظ النتائج --}}
    @if ($results->isNotEmpty())
        <x-filament::button color="success" class="mt-4" wire:click="saveResults">
            حفظ جميع الأنشطة
        </x-filament::button>

        {{-- عداد الحفظ --}}
        @if (count($savedPlaces) > 0)
            <div class="mt-2 text-green-600 font-semibold">
                ✅ تم حفظ {{ count($savedPlaces) }} نشاط
            </div>
        @endif


         {{-- عرض معلومات الفلترة لمرة واحدة فقط --}}
        <div class="mt-4 bg-gray-50 border border-gray-200 p-4 rounded-md text-sm text-gray-700">
            <div class="flex flex-wrap gap-4">
                <div>🏛️ <strong>المحافظة:</strong> {{ $governorateName ?? 'غير محددة' }}</div>
                <div>🏙️ <strong>المدينة:</strong> {{ $locationName ?? 'غير محددة' }}</div>
                <div>🏷️ <strong>التصنيف:</strong> {{ $categoryName ?? 'غير محددة' }}</div>
            </div>
        </div>
    @endif
    
    
    

    {{-- عرض النتائج --}}
    @if ($results->isNotEmpty())
        <div class="grid grid-cols-1 gap-6 mt-6">
            @foreach ($results as $place)
                <div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden p-4">
                    <div class="flex flex-col md:flex-row items-start gap-6">
                        
                    {{-- صورة النشاط في أقصى اليسار --}}
                    <div class="w-40 flex-shrink-0 self-start">
                        @if (!empty($place['photo_url']))
                            <img style=" width: 450px; height: 450px; " src="{{ $place['photo_url'] }}" alt="صورة النشاط"
                                class="rounded-md shadow-sm border border-gray-300 w-[160px] h-[120px] object-cover object-center">
                        @else
                            <div class="w-[160px] h-[120px] flex items-center justify-center text-gray-400 italic border border-dashed border-gray-300 rounded-md">
                                لا توجد صورة
                            </div>
                        @endif
                    </div>

                        {{-- تفاصيل النشاط --}}
                        <div class="flex-1 space-y-2 text-sm text-gray-700">
                            <h2 class="text-xl font-bold text-gray-800">{{ $place['name'] ?? 'بدون اسم' }}</h2>

                            <div class="flex items-center gap-1"><span>📍</span> <span>{{ $place['address'] ?? 'غير متوفر' }}</span></div>
                            <div class="flex items-center gap-1"><span>📞</span> <span>{{ $place['phone'] ?? 'غير متوفر' }}</span></div>
                            <div class="flex items-center gap-1"><span>🌐</span> <span>{{ $place['website'] ?? 'غير متوفر' }}</span></div>
                            <div class="flex items-center gap-1"><span>🆔</span> <span>{{ $place['place_id'] }}</span></div>
                            @if (!empty($place['rating']))
                                <div class="flex items-center gap-1">
                                    <span>⭐</span>
                                    <span>{{ $place['rating'] }} من 5</span>
                                </div>
                            @endif

                            @if (!empty($place['reviews_count']))
                                <div class="flex items-center gap-1">
                                    <span>🗣️</span>
                                    <span>{{ $place['reviews_count'] }} مراجعة</span>
                                </div>
                            @endif


                            <div class="bg-gray-100 inline-block px-2 py-1 rounded text-xs">
                                🧭 خط العرض: {{ $place['latitude'] ?? 'غير متوفر' }} | خط الطول: {{ $place['longitude'] ?? 'غير متوفر' }}
                            </div>

                            {{-- أوقات الدوام --}}
                            @if (!empty($place['opening_hours']))
                                <div class="mt-2">
                                    <strong class="block mb-1 text-gray-800">🕒 أوقات الدوام:</strong>
                                    <table class="text-xs border w-full bg-white rounded">
                                        @foreach ($place['opening_hours'] as $hour)
                                            <tr class="border-b">
                                                <td class="px-2 py-1">{{ $hour }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            @endif
                            

                            {{-- التصنيفات --}}
                            @if (!empty($place['types']))
                                <div class="mt-2">
                                    <strong class="block mb-1 text-gray-800">🏷️ التصنيفات:</strong>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($place['types'] as $type)
                                            <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2 py-1 rounded-full">
                                                {{ $type }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $place['latitude'] }},{{ $place['longitude'] }}" target="_blank" class="text-blue-600 underline">
                                عرض على الخريطة
                            </a>

                            {{-- زر الحفظ الفردي --}}
                            <div class="mt-4">
                                @if (in_array($place['place_id'], $this->savedPlaces))
                                    <span class="text-green-600 font-semibold text-sm flex items-center gap-1">
                                        ✅ تم الحفظ
                                    </span>
                                @else
                                    <x-filament::button wire:click="saveSinglePlace('{{ $place['place_id'] }}')" size="sm" color="success" icon="heroicon-o-bookmark">
                                        حفظ هذا النشاط
                                    </x-filament::button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


            @endforeach
        </div>
    @endif


</x-filament::page>
