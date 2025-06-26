@extends('layouts.app')
@section('content')

<div class="authbg py-5">
    <div class="container auth-container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="card shadow border-0 rounded-3 authcard">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">تسجيل دخول المستخدم</h2>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- البريد الإلكتروني -->
                            <div class="mb-3">
                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                <input id="email" type="email" name="email" class="form-control" placeholder="أدخل البريد الإلكتروني" value="{{ old('email') }}" required>
                                @error('email')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- كلمة المرور -->
                            <div class="mb-3">
                                <label for="password" class="form-label">كلمة المرور</label>
                                <input id="password" type="password" name="password" class="form-control" placeholder="أدخل كلمة المرور" required>
                                @error('password')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- تذكرني -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">تذكرني</label>
                            </div>

                            <!-- زر الدخول -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">تسجيل الدخول</button>
                            </div>

                            <!-- رابط نسيان كلمة المرور -->
                            @if (Route::has('password.request'))
                                <div class="text-center mb-2">
                                    <a href="{{ route('password.request') }}" class="text-decoration-none text-sm">هل نسيت كلمة المرور؟</a>
                                </div>
                            @endif

                            <!-- رابط التسجيل -->
                            <div class="text-center mt-3">
                                <p>لا تملك حساباً؟ 
                                    <a href="{{ route('register') }}" class="text-primary fw-bold">أنشئ حساب جديد</a>
                                </p>
                            </div>
                        </form>

                        <!-- تسجيل الدخول عبر وسائل التواصل -->
                        <hr class="my-4">
                        <div class="text-center mb-2">
                            <span class="text-muted">أو سجل الدخول باستخدام</span>
                        </div>
                        <div class="d-flex justify-content-center gap-3">
                            <a class="btn btn-outline-secondary" href="{{ route('social.redirect.google') }}">
                                <i class="bi bi-google fs-4"></i>
                            </a>
                            <a class="btn btn-outline-primary" href="{{ route('social.redirect.facebook') }}">
                                <i class="bi bi-facebook fs-4"></i>
                            </a>
                            <a class="btn btn-outline-info" href="{{ route('social.redirect.twitter') }}">
                                <i class="bi bi-twitter-x fs-4"></i>
                            </a>
                            <a class="btn btn-outline-dark" href="{{ route('social.redirect.linkedin') }}">
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
