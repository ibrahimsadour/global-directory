@if ($latestBusinesses->count())
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
            <div class="overflow-x-auto">
                <div class="flex space-x-4"> <!-- المسافة بين العناصر باستخدام space-x-4 -->
                    @foreach ($latestBusinesses as $index => $business)
                        <div class="flex-shrink-0 w-64 @if ($index == 0) ml-6 @endif">
                            <!-- إضافة ml-6 فقط للعنصر الأول -->
                            <div class="card shadow-sm h-100 overflow-hidden bg-white rounded-lg">
                                <!-- ✅ صورة النشاط -->
                                <a href="{{ route('business.show', $business->slug) }}"
                                    class="position-relative d-block overflow-hidden">
                                    @php
                                        $image = $business->image;
                                        if (empty($image)) {
                                            $imageUrl = asset('storage/business_photos/default.webp');
                                        } elseif (Str::startsWith($image, 'http')) {
                                            $imageUrl = $image;
                                        } elseif (Str::contains($image, '/')) {
                                            $imageUrl = asset('storage/' . $image);
                                        } else {
                                            $imageUrl =
                                                'https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photo_reference=' .
                                                $image .
                                                '&key=' .
                                                config('services.google.maps_api_key');
                                        }
                                    @endphp

                                    <img src="{{ $imageUrl }}" alt="{{ $business->name }}" class="w-full"
                                        style="height: 180px; object-fit: cover; border-top-left-radius: .5rem; border-top-right-radius: .5rem;">

                                    <!-- ✅ شارة الفئة -->
                                    <div class="small px-3 py-1 text-white"
                                        style="background: linear-gradient(to right, #02144270, #0062ff);">
                                        <i class="bi bi-tag me-1"></i> {{ $business->category->name ?? 'بدون فئة' }}
                                    </div>
                                </a>

                                <!-- ✅ التفاصيل -->
                                <div class="card-body p-3 flex flex-col justify-between">
                                    <div class="mb-2">
                                        <h5 class="card-title text-truncate mb-1">
                                            <a href="{{ route('business.show', $business->slug) }}"
                                                class="text-dark text-decoration-none">
                                                <span class="text-gray-800">{{ $business->name }}</span>
                                                <!-- أضفنا text-gray-800 لتغيير اللون إلى أغمق -->
                                            </a>
                                        </h5>


                                        <!-- ✅ التقييم -->
                                        @php
                                            $rating = $business->googleData->google_rating ?? 0;
                                            $fullStars = floor($rating);
                                            $halfStar = $rating - $fullStars >= 0.5;
                                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                        @endphp

                                        @if ($rating > 0)
                                            <div class="d-flex align-items-center small text-warning">
                                                @for ($i = 0; $i < $fullStars; $i++)
                                                    <i class="bi bi-star-fill"></i>
                                                @endfor
                                                @if ($halfStar)
                                                    <i class="bi bi-star-half"></i>
                                                @endif
                                                @for ($i = 0; $i < $emptyStars; $i++)
                                                    <i class="bi bi-star"></i>
                                                @endfor
                                                <span class="text-dark ms-1">{{ number_format($rating, 1) }}</span>
                                            </div>
                                        @endif

                                        <!-- ✅ وصف مختصر -->
                                        {{-- <p class="text-muted mt-2 mb-1 text-sm"
                                            style="font-size: 0.85rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                            {{ strip_tags($business->description) }}
                                        </p> --}}
                                    </div>

                                    <!-- ✅ معلومات النشاط -->
                                    <ul class="list-unstyled small mb-2">
                                        <li><i class="bi bi-telephone me-1 text-secondary"></i>
                                            {{ $business->phone ?? '------' }}</li>
                                        <li><i class="bi bi-geo-alt me-1 text-secondary"></i>
                                            {{ $business->location->area ?? '-' }} -
                                            {{ $business->governorate->name ?? '-' }}</li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endif
