@php
    $image = $business->image;
    $imageUrl = $image
        ? (Str::startsWith($image, 'http') ? $image : asset('storage/' . $image))
        : asset('storage/business_photos/default.webp');
@endphp

<div class="bg-white p-4 rounded shadow flex flex-row md:flex-col gap-4">
    <div class="w-1/3 md:w-full">
        <a href="{{ url('business/' . $business->slug) }}">
            <img src="{{ $imageUrl }}" alt="{{ $business->name }}" class="w-full h-40 object-cover rounded">
        </a>
    </div>

    <div class="w-2/3 md:w-full flex flex-col justify-between">
        <div>
            <a href="{{ url('business/' . $business->slug) }}" class="text-lg font-bold text-gray-800 hover:text-blue-600">
                {{ $business->name }}
            </a>
            {{-- <p class="text-sm text-gray-600 my-1">{{ Str::limit($business->description, 100) }}</p> --}}

            <!-- ✅ معلومات الاتصال: رقم + المدينة كل واحد في سطر -->
            <div class="text-sm text-gray-500 mt-2 space-y-1">
                @if($business->phone)
                    <div><i class="bi bi-telephone"></i> {{ $business->phone }}</div>
                @endif

                {{-- <div><i class="bi bi-envelope"></i> {{ $business->email }}</div> --}}
                
                @if($business->governorate?->name)
                    <div><i class="bi bi-geo-alt"></i> {{ $business->governorate->name }}</div>
                @endif
                @php
                    $status = $business->getOpeningStatus();
                @endphp

                <div class="text-sm font-semibold flex items-center gap-1 {{ $status['status'] === 'open' ? 'text-green-600' : 'text-red-600' }}">
                    <i class="bi bi-clock"></i>
                    {{ $status['label'] }}
                </div>

                {{-- <div><i class="bi bi-map"></i> {{ $business->address }}</div> --}}
            </div>
        </div>

        <div class="flex justify-between items-center mt-3">
            <div class="text-yellow-400">
                @php
                    $googleData = $business->googleData ?? null;
                    $rating = $googleData->google_rating ?? 0;
                    $reviews = $googleData->google_reviews_count ?? 0;
                @endphp

                @for ($i = 0; $i < 5; $i++)
                    <i class="bi {{ $i < floor($rating) ? 'bi-star-fill' : 'bi-star' }}"></i>
                @endfor
                <small class="text-gray-500">({{ number_format($rating, 1) }} / {{ $reviews }} مراجعة)</small>
            </div>

            {{-- <div>
                <a data-bs-toggle="modal" data-bs-target="#loginAlert" class="text-red-500">
                    <i class="bi bi-heart"></i>
                </a>
            </div> --}}
        </div>
    </div>
</div>

