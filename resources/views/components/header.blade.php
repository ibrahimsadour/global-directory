<header>
    <div class="container head-container">
    <div class="row">
        <div  class="col-lg-3 col-md-4 logo">
            <a href="{{ route('home.index') }}" class="cp">
            <img src="{{ setting('site_logo') ? asset('storage/' . setting('site_logo')) : asset('storage/site-settings/default-logo.webp') }}" alt="{{ setting('site_title', 'Global Directory') }}" title="{{ setting('site_title', 'Global Directory') }}" style="height: 50px;">
            </a> 
            <a class="d-md-none small-menu" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <button style="font-weight: 500;" type="button" class="btn btn-outline-primary">انشر نشاطك تجاري ✚</button>
            </a>
            

            <div class="offcanvas home-mobile-menu offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h4>مرحباً بالضيف</h4>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.html"><i class="bi bi-house-door"></i> الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="login.html"><i class="bi bi-plus-square"></i> اضف موقعك</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.html"><i class="bi bi-unlock"></i> تسجيل الدخول</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="registration.html"><i class="bi bi-person-plus"></i> التسجيل</a>
                        </li>
                    </ul>
                    
                    {{-- <div class="search-cover p-3">
                        <p><b>Search :</b> </p>
                        <select onchange="change_city()" required name="city" id="bb" class="form-control rounded-start">
                            <option value="">كل المحافظات</option>
                        </select>
                        <div class="input-group mb-3">
                        <button type="submit" class="btn rounded-end btn-primary"><i class="bi bi-search"></i></button>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <div  class="col-lg-5 d-none d-lg-block col-md-8 search">
            <div class="search-row row no-margin">
                <div x-data="" class="col-md-4 no-padding">
                <form id="location" action="#" method="post">
                    <input type="hidden" name="_token"  autocomplete="off">                           
                    <select  name="location" id="bb" class="form-control rounded-start">
                        <option value=""   </option>
                        @if(!empty($governorates) && $governorates->count())
                            @foreach($governorates as $governorate)
                                <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                            @endforeach
                        @else
                            <option disabled selected>لا توجد محافظات متاحة</option>
                        @endif
                    </select>
                </form>
                </div>
                <form class="display-contents" action="#" method="post">
                <input type="hidden" name="_token" value="qbHoaClofDRMUj8Fr2MUCq0W5WYZC3Z5fVZspNFG" autocomplete="off">                        
                <div class="col-md-7 no-padding">
                    <input type="text" name="key" value="" required placeholder="Search Business" class="form-control ">
                </div>
                <div class="col-md-1  no-padding">
                    <button type="submit" class="btn rounded-end btn-primary"><i class="bi bi-search"></i></button>
                </div>
                </form>
            </div>
        </div>
        <div class="col-lg-4 col-md-8 slink  d-none d-md-block  right">
            <ul class="float-end">
                <li class="me-3"><a href="{{ route('register') }}"><button type="button" class="btn btn-outline-primary">إضافة عمل تجاري ✚</button></a></li>
                <li ><a href="{{ route('register') }}"><button class="btn btn-primary ">إنشاء حساب جديد</button></a></li>
            </ul>
        </div>
    </div>
    </div>
</header>