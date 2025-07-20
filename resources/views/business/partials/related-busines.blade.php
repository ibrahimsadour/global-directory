<!-- ✅ نشاطات ذات صلة -->
<div class="overview shadow-sm mt-3">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 px-2">
        <h2 class="m-0 homepage-title" style="font-size: 1.3rem;">نشاطات ذات صلة</h2>

        <a href="{{ route('categories.show', $business->category->slug) }}"
        class="text-primary d-inline-flex align-items-center fw-bold"
        style="font-size: 0.9rem;">
            عرض الكل
            <i class="bi bi-arrow-left-short fs-5 ms-1"></i>
        </a>
    </div>

    <div class="row gy-4 p-2">
        @foreach($related as $item)
        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{{ route('business.show', $item->slug) }}"
               class="text-decoration-none text-dark d-block border rounded shadow-sm h-100 overflow-hidden">
               
                {{-- ✅ الصورة --}}
                @php
                    $image = $item->image;
                    if (empty($image)) {
                        $imageUrl = asset('storage/business_photos/default.webp');
                    } elseif (Str::startsWith($image, 'http')) {
                        $imageUrl = $image;
                    } elseif (Str::contains($image, '/')) {
                        $imageUrl = asset('storage/' . $image);
                    } else {
                        $imageUrl = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photo_reference=' 
                            . $image . '&key=' . config('services.google.maps_api_key');
                    }
                @endphp

                <div style="width: 100%; aspect-ratio: 1/1; overflow: hidden;">
                    <img src="{{ $imageUrl }}"
                         alt="{{ $item->name }}"
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>

                {{-- ✅ المعلومات --}}
                <div class="p-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <small class="text-muted text-truncate d-block" style="max-width: 140px;">
                            <i class="bi bi-tag"></i> {{ $item->category->name ?? 'بدون فئة' }}
                        </small>
                    </div>
                    <h6 class="text-truncate mb-1 homepage-title">{{ $item->name }}</h6>

                    {{-- ✅ التقييم --}}
                    <div class="d-flex flex-column">
                        @php
                            $googleRating = $item->googleData->google_rating ?? 0;
                            $reviewsCount = $item->googleData->google_reviews_count ?? 0;

                            $fullStars = floor($googleRating);
                            $halfStar = ($googleRating - $fullStars) >= 0.5;
                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                        @endphp

                        <div class="text-warning" title="متوسط التقييم {{ number_format($googleRating, 1) }} من 5">
                            @for ($i = 0; $i < $fullStars; $i++)
                                <i class="bi bi-star-fill fs-6"></i>
                            @endfor
                            @if ($halfStar)
                                <i class="bi bi-star-half fs-6"></i>
                            @endif
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <i class="bi bi-star fs-6"></i>
                            @endfor

                            <span class="text-dark ms-1" title="{{ number_format($googleRating, 1) }} من 5">
                                {{ number_format($googleRating, 1) }}
                            </span>
                        </div>

                        <small class="text-muted">
                            <i class="bi bi-google text-danger me-1"></i>
                            ({{ $reviewsCount }} تقييم على غوغل)
                        </small>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
