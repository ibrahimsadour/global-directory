<div class="side-card">
    <div class="row user-prof">
        <div class="image col-3">
            <img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('storage/profile-photos/default.webp') }}" alt="">
        </div>
        <div class="col-9 detail">
            <h6> مرحبا {{ auth()->user()->name }}</h6>
            <p>
                @if(auth()->user()->status)
                    <span class="text-success">
                        <i class="bi bi-circle-fill" style="color: green;"></i> متصل الآن
                    </span>
                @else
                    <span class="text-secondary">
                        <i class="bi bi-circle" style="color: gray;"></i> غير متصل
                    </span>
                @endif
            </p>

        </div>
    </div>
    <div class="row user-menu">
    <ul class="no-padding">
        <li class="{{ request()->routeIs('user.dashboard') ? 'act' : '' }}">
            <a href="{{ route('user.dashboard') }}"><i class="bi bi-speedometer2"></i> لوحة التحكم</a>
        </li>
        <li class="{{ request()->routeIs('user.my-business') ? 'act' : '' }}">
            <a href="{{ route('user.my-business') }}"><i class="bi bi-list-stars"></i> إعلاناتي</a>
        </li>
        <li class="{{ request()->routeIs('user.business.create') ? 'act' : '' }}">
            <a href="{{ route('user.business.create') }}"><i class="bi bi-plus-square"></i> إضافة إعلان جديد</a>
        </li>


        <li><a href="#"><i class="bi bi-heart"></i> المفضلة (قريبا)</a></li>
        <li class=""><i class="bi bi-star"></i> التقييمات (قريبا)</li>
        <li class=""><i class="bi bi-chat-square-text"></i> الرسائل (قريبا)</li>
        <li><a href="#"><i class="bi bi-credit-card-2-front"></i> الخطة الحالية (قريبا)</a></li>
        <li><a href="#"><i class="bi bi-credit-card-2-back"></i> المدفوعات (قريبا)</a></li>

        <li class="{{ request()->routeIs('user.profile.edit') ? 'act' : '' }}" >
            <a href="{{ route('user.profile.edit') }}"><i class="bi bi-person"></i> الملف الشخصي</a>
        </li>
        <li class="{{ request()->routeIs('user.settings') ? 'act' : '' }}">
            <a href="{{ route('user.settings') }}"><i class="bi bi-gear"></i> إعدادات الحساب</a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <i class="bi bi-box-arrow-left"></i>
                <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); this.closest('form').submit();">
                    تسجيل الخروج
                </a>
            </form>
        </li>
    </ul>

    </div>
    </div>

    <div class="ad-slot mt-3">
        <img src="assets/images/ad.jpg" alt="">
    </div>
</div