@extends('layouts.app')
@section('content')
    <div id="app">
        <div class="authbg" >
            <div class="container auth-container" >
                <div class="row" >
                    <div class="col-xl-6 col-lg-7 col-md-10 mx-auto shadow authcard" >
                        <div class="titlecover" ><h2>انشاء حساب شخصى جديد</h2></div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="row form-row">
                                <div class="col-md-4">
                                    <label for="name">الاسم</label><span class="spcol">:</span>
                                </div>
                                <div class="col-md-8">
                                    <input type="text"
                                        id="name"
                                        name="name"
                                        class="form-control"
                                        placeholder="أدخل الاسم الكامل"
                                        value="{{ old('name') }}"
                                        required
                                        autofocus
                                        autocomplete="name" />

                                    @error('name')
                                        <p class="text-sm text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="row form-row">
                                <div class="col-md-4"><label>البريد الالكتروني</label><span class="spcol">:</span></div>
                                <div class="col-md-8">
                                    <input id="email"
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        placeholder="أدخل عنوان البريد الإلكتروني"
                                        value="{{ old('email') }}"
                                        required
                                        autocomplete="username">                                
                                </div>
                                @error('email')
                                    <div class="mt-2 text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="row form-row">
                                <div class="col-md-4">
                                    <label for="password">كلمة المرور</label><span class="spcol">:</span>
                                </div>
                                <div class="col-md-8">
                                    <input type="password"
                                        id="password"
                                        name="password"
                                        class="form-control"
                                        placeholder="أدخل كلمة المرور"
                                        autocomplete="new-password"
                                        required />

                                    @error('password')
                                        <p class="text-sm text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="row form-row">
                                <div class="col-md-4">
                                    <label for="password_confirmation">تأكيد كلمة المرور</label><span class="spcol">:</span>
                                </div>
                                <div class="col-md-8">
                                    <input type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        class="form-control"
                                        placeholder="أدخل تأكيد كلمة المرور"
                                        autocomplete="new-password"
                                        required />

                                    @error('password_confirmation')
                                        <p class="text-sm text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-8 fpswd">
                                    <button type="submit" class="btn px-4 btn-primary">
                                        إنشاء حساب جديد
                                    </button>
                                    <a href="{{ route('password.request') }}">نسيت كلمة المرور؟</a>
                                </div>
                            </div>

                            <div class="row mt-5 text-center form-row">
                                <p>
                                    لديك حساب بالفعل؟
                                    <a class="text-primary" href="{{ route('login') }}">
                                        <b>اضغط لتسجيل الدخول</b>
                                    </a>
                                </p>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
