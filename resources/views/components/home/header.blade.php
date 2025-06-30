<div class="slider-contaienr container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 searchcol">
                <h1 class="homepage-title">{{setting('site_title')}}</h1>
                <p>{{setting('site_description')}}<p>
                <form action="{{ route('search') }}" method="GET" role="search"> 
                    <input type="hidden" name="key" value="{{ request('key') }}" autocomplete="on" />
                    <div class="search-box-card no-margin row">
                        <div style="width: 100%;" class="col-md-6 no-padding">
                            <div class="input-group">
                                <input
                                    type="text"
                                    class="form-control border border-2 border-gray-500"
                                    name="key"
                                    placeholder="ابحث عن المحلات التجارية والخدمات وما إلى ذلك..."
                                    style="height: 36px;"
                                >
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