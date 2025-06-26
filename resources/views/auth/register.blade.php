@extends('layouts.app')
@section('content')

<div class="authbg py-5">
    <div class="container auth-container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10">
                <div class="card shadow border-0 rounded-3 authcard">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">إنشاء حساب شخصي جديد</h2>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- الاسم الكامل -->
                            <div class="mb-3">
                                <label for="name" class="form-label">الاسم الكامل</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="أدخل الاسم الكامل" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- البريد الإلكتروني -->
                            <div class="mb-3">
                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="أدخل البريد الإلكتروني" value="{{ old('email') }}" required>
                                @error('email')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- كلمة المرور -->
                            <div class="mb-3">
                                <label for="password" class="form-label">كلمة المرور</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="أدخل كلمة المرور" required>
                                @error('password')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- تأكيد كلمة المرور -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="أدخل تأكيد كلمة المرور" required>
                                @error('password_confirmation')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- زر التسجيل -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">إنشاء حساب جديد</button>
                            </div>

                            <!-- رابط نسيان كلمة المرور -->
                            @if (Route::has('password.request'))
                                <div class="text-center mb-2">
                                    <a href="{{ route('password.request') }}" class="text-decoration-none text-sm">نسيت كلمة المرور؟</a>
                                </div>
                            @endif

                            <!-- رابط تسجيل الدخول -->
                            <div class="text-center mt-3">
                                <p>لديك حساب بالفعل؟ 
                                    <a href="{{ route('login') }}" class="text-primary fw-bold">اضغط لتسجيل الدخول</a>
                                </p>
                            </div>
                        </form>

                        <!-- تسجيل الدخول عبر وسائل التواصل -->
                        <hr class="my-4">
                        <div class="text-center mb-2">
                            <span class="text-muted">أو سجل باستخدام</span>
                        </div>
                        <div class="d-flex justify-content-center gap-3">
                            <a class="btn btn-outline-secondary" href="{{ route('social.redirect', 'google') }}">
                                <i class="bi bi-google fs-4"></i>
                            </a>
                            <a class="btn btn-outline-primary" href="{{ route('social.redirect', 'facebook') }}">
                                <i class="bi bi-facebook fs-4"></i>
                            </a>
                            <a class="btn btn-outline-info" href="{{ route('social.redirect', 'twitter') }}">
                                <i class="bi bi-twitter-x fs-4"></i>
                            </a>
                            <a class="btn btn-outline-dark" href="{{ route('social.redirect', 'linkedin') }}">
                                <i class="bi bi-linkedin fs-4"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
