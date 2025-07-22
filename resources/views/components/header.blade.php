<header>
    <!-- ✅ إشعار DalilGo -->
    <div id="dalilgo-popup" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
        <div class="bg-white w-full max-w-md mx-4 rounded-2xl p-6 shadow-lg relative text-center">
            <!-- زر الإغلاق -->
            <button onclick="closePopup()" class="absolute top-2 left-2 text-gray-500 hover:text-red-600 text-2xl">&times;</button>

            <!-- محتوى الإشعار -->
            <h2 class="text-xl font-bold mb-3 text-yellow-700">🚧 تنويه هام</h2>
            <p class="text-sm text-gray-700">
                منصة <strong>DalilGo</strong> ما زالت قيد التطوير. نحن نعمل على تحسين التجربة باستمرار، ونقدّر زيارتك ودعمك 🙏
            </p>
        </div>
    </div>

    <!-- ✅ JavaScript (تأخير 5 ثواني) -->
    <script>
        window.addEventListener('load', function () {
            setTimeout(() => {
                document.getElementById('dalilgo-popup').classList.remove('hidden');
            }, 5000); // يظهر بعد 5 ثواني
        });

        function closePopup() {
            document.getElementById('dalilgo-popup').classList.add('hidden');
        }
    </script>


    <div class="container head-container">
        <div class="row">
            <div class="col-lg-3 col-md-4 logo">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <a href="{{ route('home.index') }}" class="cp">
                        <img
                            src="{{ setting('site_logo') ? asset('storage/' . setting('site_logo')) : asset('storage/site-settings/default-logo.webp') }}"
                            alt="{{ setting('site_title', 'Global Directory') }}"
                            title="{{ setting('site_title', 'Global Directory') }}"
                        />
                    </a>
                    
                    <a 
                        class="md:hidden bg-white rounded-full p-2 shadow-md hover:bg-gray-100 transition duration-200" 
                        data-bs-toggle="offcanvas" 
                        data-bs-target="#offcanvasNavbar" 
                        aria-controls="offcanvasNavbar" 
                        title="القائمة"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.5 12.5h13v-1h-13v1zm0-4h13v-1h-13v1zm0-5v1h13v-1h-13z"/>
                        </svg>
                    </a>

                </div>

                <div class="offcanvas home-mobile-menu offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h4>مرحباً بالضيف</h4>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#"><i class="bi bi-house-door"></i> الرئيسية</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#"><i class="bi bi-plus-square"></i> اضف موقعك</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="bi bi-unlock"></i> تسجيل الدخول</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="bi bi-person-plus"></i> التسجيل</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block col-md-8 search">
                <div class="search-row row no-margin">
                    <form action="{{ route('search') }}" method="GET" class="d-flex">
                        <input type="text" name="key" class="form-control" placeholder="ابحث عن نشاط..." value="{{ request('key') }}" />
                        <button style="width: 10%;" type="submit" class="btn rounded-end btn-primary"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>
            @if (Auth::check())
            <div class="col-lg-4 col-md-8 slink d-none d-md-block login-options right">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img 
                            src="{{ auth()->user()->profile_photo 
                                ? (Str::startsWith(auth()->user()->profile_photo, 'http') 
                                    ? auth()->user()->profile_photo 
                                    : asset('storage/' . auth()->user()->profile_photo)) 
                                : asset('storage/profile-photos/default.webp') }}" 
                            alt=""
                        >
                        <span class="d-none d-lg-block">{{Auth::user()->name}}</span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('user.dashboard') }}"><i class="bi bi-speedometer2"></i> لوحة التحكم</a>
                        <a class="dropdown-item" href=""><i class="bi bi-gear"></i> إعدادات</a>
                        <a class="dropdown-item" href=""><i class="bi bi-plus-square"></i>نشاط تجاري جديد</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a
                                class="dropdown-item"
                                href=""
                                onclick="event.preventDefault();
                                this.closest('form').submit();"
                            >
                                <i class="bi bi-box-arrow-in-left"></i> تسجيل الخروج
                            </a>
                        </form>
                    </div>
                </div>
            </div>
            @else
            <div class="col-lg-4 col-md-8 slink d-none d-md-block right">
                <ul class="float-end">
                    <li class="me-3">
                        <a href="{{ route('register') }}"><button type="button" class="btn btn-outline-primary">إضافة عمل تجاري ✚</button></a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}"><button class="btn btn-primary">تسجيل الدخول</button></a>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </div>
</header>
