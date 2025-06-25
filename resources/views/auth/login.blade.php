
@extends('layouts.app')
@section('content')

<div id="app">
    <div>
        <div class="authbg">
            <div class="container auth-container">
<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="row" bis_skin_checked="1">
        <div class="col-lg-6 col-md-10 mx-auto shadow authcard" bis_skin_checked="1">
            <div class="titlecover" bis_skin_checked="1">
                <h2>تسجيل دخول المستخدم</h2>
            </div>

            <!-- حقل الإيميل -->
            <div class="row form-row" bis_skin_checked="1">
                <div class="col-md-4" bis_skin_checked="1">
                    <label for="email">البريد الإلكتروني</label><span class="spcol">:</span>
                </div>
                <div class="col-md-8" bis_skin_checked="1">
                    <input id="email" type="email" name="email" class="form-control" placeholder="أدخل البريد الإلكتروني" value="{{ old('email') }}" required autocomplete="username">
                    @error('email')
                        <p class="text-danger mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- حقل كلمة المرور -->
            <div class="row form-row" bis_skin_checked="1">
                <div class="col-md-4" bis_skin_checked="1">
                    <label for="password">كلمة المرور</label><span class="spcol">:</span>
                </div>
                <div class="col-md-8" bis_skin_checked="1">
                    <input id="password" type="password" name="password" class="form-control" placeholder="أدخل كلمة المرور" required autocomplete="current-password">
                    @error('password')
                        <p class="text-danger mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- تذكرني -->
            <div class="row form-row" bis_skin_checked="1">
                <div class="col-md-4"></div>
                <div class="col-md-8 mb-3" bis_skin_checked="1">
                    <label>
                        <input name="remember" type="checkbox" class="form-check-input">
                        تذكرني
                    </label>
                </div>
            </div>

            <!-- زر الدخول ورابط نسيان كلمة المرور -->
            <div class="row form-row" bis_skin_checked="1">
                <div class="col-md-4"></div>
                <div class="col-md-8 fpswd" bis_skin_checked="1">
                    <button type="submit" class="btn btn-primary px-4">تسجيل الدخول</button>
                    @if (Route::has('password.request'))
                        <a class="text-sm ms-3" href="{{ route('password.request') }}">هل نسيت كلمة المرور؟</a>
                    @endif
                </div>
            </div>

            <!-- رابط التسجيل -->
            <div class="row mt-4 text-center form-row" bis_skin_checked="1">
                <p>
                    لا تملك حساباً؟ 
                    <a href="{{ route('register') }}" class="text-primary"><b>أنشئ حساب جديد</b></a>
                </p>
            </div>
        </div>
    </div>
</form>
                `
            </div>
        </div>
    </div>
</div>
@endsection
