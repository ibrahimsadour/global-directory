@extends('layouts.app')

{{-- السيو الافتراضي الخاص بالموقع --}}

@section('structured_data')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "{{ setting('site_title', 'Global Directory') }}",
  "url": "{{ url('/') }}",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "{{ url('/') }}?s={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "{{ setting('site_title', 'Global Directory') }}",
  "url": "{{ url('/') }}",
  "logo": "{{ setting('site_logo') ? asset('storage/' . setting('site_logo')) : asset('storage/site-settings/default-logo.webp') }}"
}
</script>
@endsection

@section('content')

    <div class="slider-contaienr container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 searchcol">
                    <h1 class="homepage-title">{{setting('site_title')}}</h1>
                    <p>{{setting('site_description')}}<p>
                    <form action="{{ route('user.search') }}" method="GET" role="search"> 
                        <input type="hidden" name="key" value="{{ request('key') }}" autocomplete="on" />
                        <div class="search-box-card no-margin row">
                            <div style="width: 100%;" class="col-md-6 no-padding">
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="key"
                                        placeholder="ابحث عن المحلات التجارية والخدمات وما إلى ذلك..."
                                        value="{{ request('key') }}"
                                    />
                                    <div class="input-group-append">
                                        <button style=" border-top-right-radius: 0%; border-bottom-right-radius: 0%; " type="submit" class="btn rounded-end btn-primary"><i class="bi bi-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <ul>
                        <li>الأقسام الأكثر بحثاً :</li>
                        @if($categories && $categories->count())
                            @foreach($categories->whereNull('parent_id')->take(5) as $category)
                                <li><a href="{{ route('categories.show', $category->slug) }}">{{ $category->name }}</a></li>
                            @endforeach
                        @else
                            <option disabled selected>لا توجد فئات متاحة</option>
                        @endif
                    </ul>
                </div>
                <div class="col-lg-5 d-none d-lg-block img-col">
                    <img src="{{ setting('site_home_banner') ? asset('storage/' . setting('site_home_banner')) : asset('storage/site-settings/default-banner.webp') }}" alt="website background" />
                </div>
            </div>
        </div>
    </div>


    {{-- عرض الفئات --}}
    <section class="container-fluid featured-category">
        <div class="container">
            <div class="section-title mb-3 row">
                <h2 class="homepage-title">إكتشف <strong class="after-category-title"> أقسامنا</strong></h2>
                <p>ألقِ نظرة على الفئة المميزة. لم تجد ما تبحث عنه؟<a class="text-primary" href="{{ route('categories.index') }}">عرض جميع الفئات</a>
            </div>
            <div class="fcatrow row">
                @foreach($categories as $category)
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6 fcatcol mb-4">
                        <a href="{{ route('categories.show',$category->slug) }}">
                            <div class="fcat shado-xs text-center">
                                <div class="icon mx-auto">
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                                    @endif
                                </div>
                                <p class="text-truncate">{{ $category->name }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
        
        </div>
    </section>

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
                                    @if($featuredBusiness->image)
                                        <img class="business-img" src="{{ asset('storage/' . $featuredBusiness->image) }}" alt="{{ $featuredBusiness->name }}" title="{{ $featuredBusiness->name }}" />
                                    @endif
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

                            <div class="foot-cover footuser">
                                <ul class="d-flex justify-content-between">
                                    <li class="rev">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <small>0.0 (0 Reviews)</small>
                                    </li>
                                    <li class="save saveuser">
                                        <a data-bs-toggle="modal" data-bs-target="#loginAlert"><i class="bi bi-heart"></i></a>
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

    
    {{-- عرض المحافظات --}}
    <section class="container-fluid featured-city">
        <div class="container">
            <div class="section-title mb-3 row">
                <h2 class="homepage-title">استكشف <strong class="after-category-title"> المواقع</strong> المزدحمة</h2>
                <p>لم تجد ما تبحث عنه؟ <a class="text-primary" href="{{ route('governorates.index') }}" title="عرض جميع المحافظات">عرض جميع المحافظات</a></p>
            </div>

            <div class="row cityrow">
                @if($governorates && $governorates->count()) @foreach($governorates as $governorate)
                <div class="col-lg-3 col-md-4 col-sm-6 citycol">
                    <a href="#">
                        <div class="citycover">
                            <a href="{{ route('governorates.show', $governorate->slug) }}" title="{{ $governorate->name ?? '-' }}" alt="{{ $governorate->name ?? '-' }}">
                                <div class="row g-0">
                                    <div class="col-md-4 col-4">
                                        @if($governorate->image)
                                        <img src="{{ asset('storage/' . $governorate->image) }}" alt="{{ $governorate->name }}" class="img-fluid rounded" title="{{ $governorate->name ?? '-' }}" alt="{{ $governorate->name ?? '-' }}" />
                                        @endif
                                    </div>
                                    <div class="col-md-8 col-8 my-auto ps-2">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $governorate->name ?? '' }}</h5>
                                            <p class="card-text">{{ $governorate->locations_count ?? '' }} عدد المدن</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </a>
                </div>
                @endforeach @else
                <p>لا توجد مواقع متاحة</p>
                @endif
            </div>
        </div>
    </section>

    {{-- عرض اخر الاعلانات المضافة --}}
    @if($latestBusinesses->count()) 
        <div class="featured-listing container-fluid">
            <div class="container">
                <div class="section-title mb-3 row">
                    <h2 class="homepage-title" >أحدث <strong class="after-category-title"> الأعمال</strong> التجارية</h2>
                    <p>ألقِ نظرة على الإعلانات المُضافة حديثًا. لم تجد ما تبحث عنه؟ <a class="text-primary" href="{{ route('categories.index') }}">عرض جميع الاعمال التجارية</a></p>
                </div>

                <div class="featuredrow row">
                    @foreach($latestBusinesses as $latestBusiness)
                    <div class="col-lg-4 col-md-6">
                        <div class="featurdlist rounded-sm shado-sm">
                            <div class="image-cover">
                                <a href="{{ route('business.show', $latestBusiness->slug) }}">
                                    @if($latestBusiness->image)
                                    <img src="{{ asset('storage/' . $latestBusiness->image) }}" class="business-img" title="{{ $latestBusiness->name ?? '-' }}" alt="{{ $latestBusiness->name ?? '-' }}" />
                                    @endif
                                </a>
                                @if($latestBusiness->image)
                                <div class="cat-cover">
                                    {{ $latestBusiness->category->name ?? 'بدون فئة' }}
                                </div>
                                @endif
                            </div>
                            <div class="detail-cov">
                                <a href="{{ route('business.show', $latestBusiness->slug) }}" title="{{ $latestBusiness->name ?? '-' }}">
                                    <h4>{{ $latestBusiness->name ?? '-' }}</h4>
                                    <p class="text-truncate">{{ $latestBusiness->description ?? '-' }}</p>
                                    <ul>
                                        <li><i class="bi bi-telephone"></i> {{ $latestBusiness->phone ?? '-' }}</li>
                                        <li><i class="bi bi-geo-alt"></i> {{ $latestBusiness->governorate->name ?? '-' }}</li>
                                    </ul>
                                </a>
                            </div>
                            <div class="foot-cover footuser">
                                <ul class="d-flex justify-content-between">
                                    <li class="user">
                                        @if($latestBusiness->user->profile_photo)
                                            
                                        @endif
                                        <span>
                                            {{ $latestBusiness->user?->name ?? 'غير معروف' }} @if($latestBusiness->user?->is_verified)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <g clip-path="url(#clip0_3387_26479)">
                                                    <path
                                                        d="M7.99984 0.666626C6.96781 0.666626 6.08268 1.19705 5.5117 1.98101C4.54887 1.83055 3.54245 2.08367 2.813 2.81312C2.08243 3.54368 1.83522 4.55048 1.9869 5.50808C1.20431 6.08082 0.666504 6.96446 0.666504 7.99996C0.666504 9.03546 1.20431 9.9191 1.9869 10.4918C1.83522 11.4494 2.08243 12.4562 2.813 13.1868C3.54384 13.9176 4.55031 14.1641 5.50646 14.0169C6.08037 14.8008 6.96558 15.3333 7.99984 15.3333C9.03117 15.3333 9.92201 14.8033 10.4952 14.0172C11.4508 14.1638 12.4563 13.9171 13.1867 13.1868C13.9154 12.458 14.1694 11.4519 14.0188 10.4918C14.8016 9.9179 15.3332 9.03333 15.3332 7.99996C15.3332 6.96659 14.8016 6.08202 14.0188 5.50807C14.1694 4.54804 13.9154 3.54188 13.1867 2.81312C12.4584 2.08487 11.4532 1.83073 10.4937 1.98069C9.92048 1.19574 9.03028 0.666626 7.99984 0.666626Z"
                                                        fill="#0284C7"
                                                    ></path>
                                                    <path
                                                        d="M10.7655 6.14544C10.9883 6.47175 10.9044 6.91691 10.5781 7.13973L10.516 7.18215C9.45671 7.90546 8.57549 8.85981 7.93872 9.97325C7.82808 10.1667 7.63359 10.2976 7.41269 10.3272C7.1918 10.3568 6.96972 10.2817 6.81204 10.1242L5.37632 8.69005C5.09677 8.4108 5.09653 7.95781 5.37578 7.67826C5.65503 7.39871 6.10803 7.39847 6.38758 7.67772L7.19287 8.48215C7.8746 7.51282 8.72627 6.67157 9.70906 6.00047L9.77118 5.95805C10.0975 5.73523 10.5427 5.81912 10.7655 6.14544Z"
                                                        fill="white"
                                                    ></path>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_3387_26479">
                                                        <rect width="16" height="16" fill="white"></rect>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            @endif
                                        </span>
                                    </li>
                                    <li class="save saveuser">
                                        <a data-bs-toggle="modal" data-bs-target="#loginAlert"><i class="bi bi-heart"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    {{ $latestBusinesses->withQueryString()->links('vendor.pagination.custom-bootstrap') }}
                </div>
            </div>
            
        </div>
    @endif

    {{-- الأخبار والنصائح --}}
    {{-- <section class="latest-blog container-fluid">
        <div class="container">
        <div class="section-title mb-3 row">
            <h2>الأخبار & النصائح</h2>
            <p>اطلع على أحدث المقالات من مدونتنا. هل ترغب بقراءة المزيد؟ <a class="text-primary" href="view-blogs.html">عرض جميع المقالات</a></p>
        </div>
        <div class="blogrow row">
            <div class="col-lg-4 col-md-6 blog-col">
                <a href="single-blogs/ggfgfgf.html">
                    <div class="blogcover shadow-sm">
                    <div class="blog-img">
                        <img src="storage/blog/resize/YhmKEMHknLhfdKJiCR85EkqlcJATBXJGGfpMQOIv.png" alt="">
                    </div>
                    <div class="info">
                        <ul>
                            <li><i class="bi bi-folder2-open"></i> test</li>
                            <li class="ms-4"><i class="bi bi-calendar2-minus"></i> Mon Apr 2025</li>
                        </ul>
                    </div>
                    <div class="detail">
                        <h2>ggfgfgf</h2>
                    </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 blog-col">
                <a href="single-blogs/demo.html">
                    <div class="blogcover shadow-sm">
                    <div class="blog-img">
                        <img src="storage/blog/resize/p8GAWFqjRLi5GSup0jOJkgVUsoRBoEgkg2BzbS4S.jpg" alt="">
                    </div>
                    <div class="info">
                        <ul>
                            <li><i class="bi bi-folder2-open"></i> Restuarent123</li>
                            <li class="ms-4"><i class="bi bi-calendar2-minus"></i> Tue Apr 2025</li>
                        </ul>
                    </div>
                    <div class="detail">
                        <h2>demo</h2>
                    </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 blog-col">
                <a href="single-blogs/fxgfd.html">
                    <div class="blogcover shadow-sm">
                    <div class="blog-img">
                        <img src="storage/blog/resize/TEpUaNFHi6VIgIqv1bzJElaJisK7caq4KGEUGgLT.jpg" alt="">
                    </div>
                    <div class="info">
                        <ul>
                            <li><i class="bi bi-folder2-open"></i> Restuarent123</li>
                            <li class="ms-4"><i class="bi bi-calendar2-minus"></i> Sat Mar 2025</li>
                        </ul>
                    </div>
                    <div class="detail">
                        <h2>fxgfd</h2>
                    </div>
                    </div>
                </a>
            </div>
        </div>
        </div>
    </section>   --}}

  
@endsection

@push('styles')
   
@endpush

@push('scripts')
    <script>
         function handleClick(e) {
             // Now you can access the event object (e) directly
         }
    </script> 
    <script>
         function handleClick(like, id) {
             axios.post('update-bookmark', {'id':id,'like':!like});
             return !like;
         }
    </script>
    <script>
         function handleChange(){
            document.getElementById("location").submit();
         }
    </script>

@endpush