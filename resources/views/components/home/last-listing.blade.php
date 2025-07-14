@if($latestBusinesses->count()) 
<div class="featured-listing container-fluid py-5 bg-light">
    <div class="container">

        <!-- ✅ العنوان -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div class="section-title">
                <h2 class="homepage-title">
                    أحدث <strong class="after-category-title">الأعمال التجارية</strong>
                </h2>
            </div>

            <a href="{{ route('categories.index') }}"
            class="text-primary d-inline-flex align-items-center fw-semibold"
            style="font-size: 0.9rem; text-decoration: none;">
                عرض الكل
                <i class="bi bi-arrow-left-short fs-4 ms-1 fw-bold"></i>
            </a>
        </div>



        <!-- ✅ الشبكة -->
        <div class="row g-4">
            @foreach($latestBusinesses as $business)
            <div class="col-6 col-lg-3">
                <div class="card shadow-sm h-100 overflow-hidden">

                    <!-- ✅ صورة النشاط -->
                    <a href="{{ route('business.show', $business->slug) }}" class="position-relative d-block overflow-hidden">
                        @php
                            $image = $business->image;
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

                        <img src="{{ $imageUrl }}"
                             alt="{{ $business->name }}"
                             class="w-100"
                             style="height: 180px; object-fit: cover; border-top-left-radius: .5rem; border-top-right-radius: .5rem;"
                        >

                    </a>

                    <!-- ✅ التفاصيل -->
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="mb-2">
                            <h5 class="card-title text-truncate mb-1">
                                <a href="{{ route('business.show', $business->slug) }}" class="text-dark text-decoration-none">
                                    {{ $business->name }}
                                </a>
                            </h5>

                            <!-- ✅ التقييم -->
                            @php
                                $rating = $business->rating ?? 0;
                                $fullStars = floor($rating);
                                $halfStar = ($rating - $fullStars) >= 0.5;
                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                            @endphp

                            <div class="d-flex align-items-center small text-warning">
                                @for ($i = 0; $i < $fullStars; $i++)
                                    <i class="bi bi-star-fill"></i>
                                @endfor
                                @if($halfStar)
                                    <i class="bi bi-star-half"></i>
                                @endif
                                @for ($i = 0; $i < $emptyStars; $i++)
                                    <i class="bi bi-star"></i>
                                @endfor
                                <span class="text-dark ms-1">{{ number_format($rating, 1) }}</span>
                            </div>

                            <!-- ✅ وصف مختصر -->
                            <p class="text-muted mt-2 mb-1" style="font-size: 0.85rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ strip_tags($business->description) }}
                            </p>
                        </div>

                        <!-- ✅ معلومات النشاط -->
                        <ul class="list-unstyled small mb-2">
                            <li><i class="bi bi-telephone me-1 text-secondary"></i> {{ $business->phone ?? '------' }}</li>
                            <li><i class="bi bi-geo-alt me-1 text-secondary"></i> {{ $business->location->area ?? '-' }} - {{ $business->governorate->name ?? '-' }}</li>
                        </ul>

                        <!-- ✅ صاحب النشاط -->
                        {{-- <div class="d-flex justify-content-between align-items-center border-top pt-2 mt-2 small text-muted">
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-semibold text-dark">
                                    {{ $business->user?->name ?? 'غير معروف' }}
                                </span>
                                @if($business->user?->is_trusted)
                                    <i class="bi bi-patch-check-fill text-primary" title="تم التحقق من صاحب النشاط"></i>
                                @endif
                            </div>
                            <a data-bs-toggle="modal" data-bs-target="#loginAlert" class="text-danger" title="أضف للمفضلة">
                                <i class="bi bi-heart"></i>
                            </a>
                        </div> --}}


                    </div>

                </div>
            </div>
            @endforeach
        </div>

        <!-- ✅ الترقيم -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $latestBusinesses->withQueryString()->links('vendor.pagination.custom-bootstrap') }}
        </div>

    </div>
</div>
@endif
