{{-- عرض المحافظات --}}
<section class="container-fluid featured-city">
    <div class="container">
        <div class="section-title mb-3 row">
            <h2 class="homepage-title">استكشف <strong class="after-category-title"> المواقع</strong> المزدحمة</h2>
            <p>لم تجد ما تبحث عنه؟ <a class="text-primary" href="{{ route('governorates.index') }}" title="عرض جميع المحافظات">عرض جميع المحافظات</a></p>
        </div>

        <div class="row cityrow">
            @if($governorates && $governorates->count()) @foreach($governorates as $governorate)
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 citycol">
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