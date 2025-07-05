{{-- عرض الاعلانات المميزة --}}
<div class="featured-listing container-fluid">
    <div class="container">
        <div class="section-title mb-3 row">
            <h2 class="homepage-title">القوائم <strong class="after-category-title"> المميزة</strong></h2>
            <p>ألقِ نظرة على العروض المميزة. لم تجد ما تبحث عنه؟ <a class="text-primary" href="{{ route('categories.index') }}">عرض جميع القوائم</a></p>
        </div>

        <div class="featuredrow row">
            @if($featuredBusinesses && $featuredBusinesses->count())
                @foreach($featuredBusinesses as $featuredBusiness)
                <div class="col-lg-4 col-md-6">
                    <div class="featurdlist rounded-sm shado-sm">
                        <div class="image-cover position-relative">
                            {{-- شارة "مميز" --}}
                            @if($featuredBusiness->is_featured)
                            <span class="featured-badge">
                                {{-- أيقونة التاج --}}
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-1">
                                    <path d="M14.3375 6.83125L12.7277 12.2969L11.0261 13.2594H6.71203L3.27453 12.2969C3.27453 12.2969 2.0084 7.97418 1.72474 7.02036L1.66465 6.83125C1.6303 6.71096 1.64742 6.58205 1.71612 6.47038L2.72164 6.05781L5.24247 7.03748L7.15895 3.77185H8.84323L10.7597 7.03748L13.2805 6.05781L14.3375 6.83125Z" fill="#FFD400"/>
                                    <path d="M14.3379 6.83125L12.728 12.2969L11.0265 13.2594H8.00146V3.77185H8.84361L10.7601 7.03748L13.2809 6.05781L14.3379 6.83125Z" fill="#FDBF00"/>
                                    <path d="M3.2749 12.2969V13.5859C3.2749 13.8265 3.4639 14.0156 3.70459 14.0156H12.2983C12.539 14.0156 12.728 13.8265 12.728 13.5859V12.2969H3.2749Z" fill="#FDBF00"/>
                                    <path d="M8.00147 1.98438C7.28812 1.98438 6.7124 2.56009 6.7124 3.27344C6.7124 4.00391 7.31396 4.5625 8.00147 4.5625C8.71481 4.5625 9.29053 3.97817 9.29053 3.27344C9.29053 2.56009 8.71481 1.98438 8.00147 1.98438Z" fill="#FDBF00"/>
                                    <path d="M14.0439 7.14063C13.6806 7.14063 13.3637 6.99919 13.1301 6.76543C12.882 6.50404 12.7549 6.19106 12.7549 5.85156C12.7549 5.14079 13.3332 4.5625 14.0439 4.5625C14.7547 4.5625 15.333 5.14079 15.333 5.85156C15.333 6.56234 14.7547 7.14063 14.0439 7.14063Z" fill="#FF9F00"/>
                                    <path d="M1.95557 7.14063C1.24479 7.14063 0.666504 6.56234 0.666504 5.85156C0.666504 5.14079 1.24479 4.5625 1.95557 4.5625C2.66634 4.5625 3.24463 5.14079 3.24463 5.85156C3.24463 6.57062 2.66578 7.14063 1.95557 7.14063Z" fill="#FDBF00"/>
                                    <path d="M8.00146 4.5625V1.98438C8.71481 1.98438 9.29053 2.56009 9.29053 3.27344C9.29053 3.97817 8.71481 4.5625 8.00146 4.5625Z" fill="#FF9F00"/>
                                    <path d="M12.728 12.2969V13.5859C12.728 13.8265 12.539 14.0156 12.2983 14.0156H8.00146V12.2969H12.728Z" fill="#FF9F00"/>
                                    <path d="M10.1317 8.4469C10.0801 8.28364 9.94269 8.17197 9.77943 8.14623L8.81689 8.00871L8.3872 7.15784C8.30988 7.02043 8.15513 6.94299 8.00048 6.94299C7.84584 6.94299 7.69109 7.02043 7.61376 7.15784L7.18408 8.00871L6.22153 8.14623C6.05827 8.17197 5.92086 8.28364 5.86928 8.4469C5.82631 8.60166 5.86928 8.77353 5.98957 8.88521L6.67707 9.54697L6.51381 10.4752C6.48796 10.6298 6.54816 10.7931 6.68568 10.8962C6.81459 10.9908 6.99508 10.9993 7.13249 10.9306L8.00048 10.4837L8.86847 10.9306C9.0145 11.0079 9.18638 10.9907 9.31539 10.8962C9.4528 10.7931 9.51301 10.6298 9.48716 10.4751L9.3239 9.54697L10.0114 8.88521C10.1317 8.77353 10.1748 8.60166 10.1317 8.4469Z" fill="#FF9F00"/>
                                    <path d="M8.86946 10.9306L8.00146 10.4837V6.94299C8.15611 6.94299 8.31086 7.02043 8.38818 7.15784L8.81787 8.00871L9.78042 8.14623C9.94368 8.17197 10.0811 8.28364 10.1327 8.4469C10.1756 8.60166 10.1327 8.77353 10.0124 8.88521L9.32488 9.54697L9.48814 10.4752C9.51399 10.6298 9.45379 10.7931 9.31626 10.8962C9.18736 10.9907 9.01548 11.0079 8.86946 10.9306Z" fill="#FF7816"/>
                                </svg>
                                <span class="ms-1">مميز</span>
                            </span>
                            @endif

                            <a href="{{ route('business.show', $featuredBusiness->slug) }}">
                                @php
                                    $image = $featuredBusiness->image;

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

                                    $altText = 'صورة نشاط ' . $featuredBusiness->name . ' في ' . optional($featuredBusiness->location)->name;
                                @endphp

                                <img 
                                    src="{{ $imageUrl }}" 
                                    class="business-img" 
                                    alt="{{ $altText }}" 
                                    title="{{ $altText }}" 
                                    loading="lazy"
                                >

                            </a>

                            @if($featuredBusiness->image)
                                <div class="cat-cover">
                                    {{ $featuredBusiness->category->name ?? 'بدون فئة' }}
                                </div>
                            @endif
                        </div>

                        <div class="detail-cov">
                            <a href="{{ route('business.show', $featuredBusiness->slug) }}" title="{{ $featuredBusiness->name }}">
                                <h4>{{ $featuredBusiness->name ?? '-' }}</h4>
                                <p class="text-truncate">{{ $featuredBusiness->description ?? '-' }}</p>
                                <ul>
                                    <li><i class="bi bi-telephone"></i> {{ $featuredBusiness->phone ?? '-' }}</li>
                                    <li><i class="bi bi-geo-alt"></i> {{ $featuredBusiness->governorate->name ?? '-' }}</li>
                                </ul>
                            </a>
                        </div>

                        @php
                            $avg = round($featuredBusiness->reviews_avg_rating ?? 0, 1);
                            $fullStars = floor($avg);
                            $halfStar = ($avg - $fullStars) >= 0.5 ? 1 : 0;
                            $emptyStars = 5 - $fullStars - $halfStar;
                        @endphp

                        <div class="foot-cover footuser">
                            <ul class="d-flex justify-content-between align-items-center">
                                <li class="rev d-flex align-items-center">
                                    {{-- نجوم كاملة --}}
                                    @for($i = 0; $i < $fullStars; $i++)
                                        <i class="bi bi-star-fill act"></i>
                                    @endfor

                                    {{-- نصف نجمة --}}
                                    @if($halfStar)
                                        <i class="bi bi-star-half act"></i>
                                    @endif

                                    {{-- نجوم فارغة --}}
                                    @for($i = 0; $i < $emptyStars; $i++)
                                        <i class="bi bi-star-fill"></i>
                                    @endfor

                                    {{-- النص --}}
                                    <small class="ms-1 text-dark">{{--{{ $avg }} --}}({{ $featuredBusiness->reviews_count }} تقييم)</small>
                                </li>

                                <li class="save saveuser">
                                    <a data-bs-toggle="modal" data-bs-target="#loginAlert">
                                        <i class="bi bi-heart"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
                {{ $featuredBusinesses->withQueryString()->links('vendor.pagination.custom-bootstrap') }}

            @else
                <p>لا توجد قوائم مميزة </p>
            @endif
        </div>
    </div>
</div>