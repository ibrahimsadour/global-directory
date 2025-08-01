<div class="businesscover shadow-sm ">
    <div class="imagecover text-center p-2">
        @php
            $image = $business->image;

            if (empty($image)) {
                $imageUrl = asset('storage/business_photos/default.webp'); // صورة افتراضية
            } elseif (Str::startsWith($image, 'http')) {
                $imageUrl = $image; // رابط خارجي مباشر
            } elseif (Str::contains($image, '/')) {
                $imageUrl = asset('storage/' . $image); // صورة من السيرفر
            } else {
                $imageUrl = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photo_reference=' 
                    . $image . '&key=' . config('services.google.maps_api_key');
            }
        @endphp

        <div style="aspect-ratio: 4 / 3; width: 100%;  overflow: hidden; border-radius: 4px;">
            <img 
                src="{{ $imageUrl }}" 
                alt="{{ $business->name }}" 
                title="{{ $business->name }}" 
                style="width: 100%; height: 100%; object-fit: cover;" 
                loading="eager"
                fetchpriority="high"

            >
        </div>
    </div>

    {{-- 👁️ عدد المشاهدات + تاريخ النشر --}}
    <div class="d-flex justify-content-between align-items-center mt-2 border-top small text-muted p-2">

        {{-- 👁️ عدد المشاهدات + تاريخ النشر --}}
        <div class="d-flex align-items-center gap-3">
            <span class="text-gray-800 homepage-title"><i class="bi bi-eye "></i> {{ $business->views()->count() }} مشاهدة</span>
            <span class="text-gray-800 homepage-title"><i class="bi bi-clock"></i> {{ $business->created_at->diffForHumans() }}</span>
        </div>

        {{-- ❤️ مفضلة + مشاركة --}}
        <div class="d-flex align-items-center gap-3">
            {{-- مفضلة (يتم فتح نافذة تسجيل الدخول مثلاً) --}}
            <a href="#" data-bs-toggle="modal" data-bs-target="#loginAlert" title="أضف إلى المفضلة">
                <i class="bi bi-heart fs-5 text-danger"></i>
            </a>

            {{-- مشاركة (نسخ الرابط) --}}
            <a href="#" onclick="navigator.clipboard.writeText(window.location.href); alert('تم نسخ الرابط!')" title="مشاركة">
                <i class="bi bi-share fs-5 text-primary"></i>
            </a>
        </div>
    </div>

    <div class="business-info p-2">

        @if(!empty($business->name))
            <h1 class="homepage-title" style=" font-size: 25px; font-weight: 600; ">{{ $business->name }}</h1>
        @endif

    </div>

    {{-- الوصف: --}}
    <div class="more-info row overview">
        <h2 class="border-bottom homepage-title">الوصف:</h2>
        @if(!empty($business->description))
            <p class="pt-2">{{ $business->description }}</p>
        @endif
    </div>
    {{-- المعلومات --}}
    <div class="more-info row overview">
        <h2 class="border-bottom homepage-title">المعلومات:</h2>
        <div class="col-lg-5 col-md-12 pt-2">
            <ul>

            @if(!empty($business->phone))
                <li>
                    <a href="tel:{{ $business->phone }}">
                        <i class="bi bi-telephone text-gray-800"></i> {{ $business->phone }}
                    </a>
                </li>
            @endif

            @if(!empty($business->email))
                <li>
                    <a href="mailto:{{ $business->email }}">
                        <i class="bi bi-envelope text-gray-800"></i> {{ $business->email }}
                    </a>
                </li>
            @endif

            @if(!empty($business->website))
                @php
                    // احصل على الدومين فقط بدون www وأي مسار بعد النطاق
                    $host = parse_url($business->website, PHP_URL_HOST);

                    // إزالة www. من البداية إذا موجود
                    $host = preg_replace('/^www\./', '', $host);
                    @endphp
                    @if(!empty($business->website))
                    <li>
                        <a href="{{ $business->website }}" target="_blank" rel="nofollow">
                            <i class="bi bi-globe text-gray-800"></i> {{ $host }}
                        </a>
                    </li>
                    @endif
            @endif

            </ul>
        </div>
        <div class="col-lg-7 col-md-12 pt-lg-2 pt-0">
            <ul>
            @if(!setting('site_address'))
                <li> <i class="bi bi-map text-gray-800"></i>{{setting('site_address')}} </li>
            @endif
            @if(!empty($business->address))
                <li class="text-truncate"><i class="bi bi-geo-alt text-gray-800"></i> {{ $business->address ? $business->address : '' }}</li>
            @endif
            @if(!empty($business->whatsapp))
                @php
                    // إزالة أي مسافات أو رموز زائدة من الرقم
                    $whatsapp = preg_replace('/\D/', '', $business->whatsapp);
                @endphp
                <li>
                    <a href="https://wa.me/965{{ $whatsapp }}" target="_blank" rel="nofollow">
                        <i class="bi bi-whatsapp text-gray-800"></i> {{ $business->whatsapp }}
                    </a>
                </li>
            @endif                     
            </ul>
        </div>
    </div>

    {{-- ⭐ تقييم الموقع --}}
<div class="footcover px-3 pb-3" x-data="review" x-init="loadReviews()">
    <div class="row gx-2 gy-2">

        {{-- ⭐ تقييم الموقع --}}
        <div class="col-12 col-md-6">
            <div class="d-flex align-items-center">
                <template x-for="s in [1,2,3,4,5]">
                    <i
                        class="bi fs-6"
                        :class="{
                            'bi-star-fill act': s <= Math.floor(avg),
                            'bi-star-half act': s === Math.ceil(avg) && avg % 1 >= 0.5 && s > Math.floor(avg),
                            'bi-star': s > avg && !(s === Math.ceil(avg) && avg % 1 >= 0.5)
                        }"
                    ></i>
                </template>
                <small class="ms-2 fw-bold" x-text="avg + ' (' + total + ' تقييم على DalilGo)'" ></small>
            </div>
        </div>

        {{-- 🌐 تقييم Google --}}
        @if(!is_null($business->googleData?->google_rating))
            <div class="col-12 col-md-6">
                <div class="d-flex align-items-center flex-wrap gap-1">
                    <i class="bi bi-google text-danger" style="font-size: 1rem;"></i>
                    <small class="fw-bold">
                        {{ number_format($business->googleData->google_rating, 2) }}
                        @if($business->googleData->google_reviews_count > 0)
                            ({{ $business->googleData->google_reviews_count }} تقييم على Google)
                        @endif
                    </small>

                    @if($business->googleData?->google_reviews_url)
                        <a href="{{ $business->googleData->google_reviews_url }}"
                        target="_blank"
                        rel="nofollow noopener noreferrer"
                        class="text-primary text-decoration-underline text-sm">
                            اقرأ المراجعات →
                        </a>
                    @endif
                </div>
            </div>
        @endif

    </div>
</div>




</div>