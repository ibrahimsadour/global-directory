<style>
    .footcover .rev i,
    .footcover .save i {
        font-size: 1.3rem;
        margin-inline-end: 4px;
    }

    .footcover .rev i.act {
        color: #f9b234; /* لون النجوم المفعلة */
    }

    .footcover .rev i:not(.act) {
        color: #ccc; /* النجوم غير المفعلة */
    }

    .footcover .save i {
        color: #dc3545; /* لون القلب (أحمر) */
    }
</style>


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

        <div style="aspect-ratio: 4 / 3; width: 100%;  overflow: hidden; border-radius: 10px;">
            <img 
                src="{{ $imageUrl }}" 
                alt="{{ $business->name }}" 
                title="{{ $business->name }}" 
                style="width: 100%; height: 100%; object-fit: cover;" 
                loading="lazy"
            >
        </div>
    </div>

    {{-- 👁️ عدد المشاهدات + تاريخ النشر --}}
    <div class="d-flex justify-content-between align-items-center mt-3 border-top small text-muted p-3">

        {{-- 👁️ عدد المشاهدات + تاريخ النشر --}}
        <div class="d-flex align-items-center gap-3">
            <span class="text-gray-800"><i class="bi bi-eye "></i> {{ $business->views()->count() }} مشاهدة</span>
            <span class="text-gray-800"><i class="bi bi-clock"></i> {{ $business->created_at->diffForHumans() }}</span>
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

    <div class="business-info">

        @if(!empty($business->name))
            <h1>{{ $business->name }}</h1>
        @endif

    </div>

    {{-- الوصف: --}}
    <div class="more-info row overview">
        <h2 class="border-bottom">الوصف:</h2>
        @if(!empty($business->description))
            <p class="pt-2">{{ $business->description }}</p>
        @endif
    </div>
    {{-- المعلومات --}}
    <div class="more-info row overview">
        <h2 class="border-bottom">المعلومات:</h2>
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
                    <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="nofollow">
                        <i class="bi bi-whatsapp text-gray-800"></i> {{ $business->whatsapp }}
                    </a>
                </li>
            @endif                     
            </ul>
        </div>
    </div>

    {{-- ⭐ تقييم الموقع --}}
    <div class="footcover px-3 pb-3" x-data="review" x-init="loadReviews()">
        <ul class="d-flex justify-content-between align-items-center small">

            {{-- ⭐ تقييم الموقع --}}
            <li class="rev d-flex align-items-center">
                <template x-for="s in [1,2,3,4,5]">
                    <i
                        class="bi"
                        :class="{
                            'bi-star-fill act': s <= Math.floor(avg),
                            'bi-star-half act': s === Math.ceil(avg) && avg % 1 >= 0.5 && s > Math.floor(avg),
                            'bi-star-fill': s > avg && !(s === Math.ceil(avg) && avg % 1 >= 0.5)
                        }"
                    ></i>
                </template>
                <small class="ms-2" x-text="avg + ' (' + total + ' تقييم)'"></small>
            </li>

                {{-- 🌐 تقييم Google --}}
            @if(!is_null($business->rating))
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-google text-danger" style=" font-size: 1.3rem; "></i>
                    <span>
                        {{ number_format($business->rating, 2) }}
                        @if($business->reviews_count > 0)
                            ({{ $business->reviews_count }} تقييم Google)
                        @endif
                    </span>
                </div>
            @endif
        </ul>
    </div>



</div>