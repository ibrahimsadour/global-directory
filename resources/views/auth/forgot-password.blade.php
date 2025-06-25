   
@extends('layouts.app')
@section('content')
<div id="app" data-page='{"component":"Auth\/ForgotPassword","props":{"errors":{},"auth":{"user":null},"status":null},"url":"\/forgot-password","version":"d8e6c71b377021f008889a4cc8d9c0b5"}' bis_skin_checked="1">
    <div class="container-fluid h-100" bis_skin_checked="1">
        <div class="oter-header" bis_skin_checked="1">
            <div class="container-fluid" bis_skin_checked="1">
                <div class="row no-margin" bis_skin_checked="1">
                    <div class="col-sm-3 login-logo" bis_skin_checked="1"><img src="../../assets/admin/images/logo.png" alt="" /></div>
                </div>
            </div>
        </div>
        <div class="row no-margin h-100" bis_skin_checked="1">
            <div class="container-fluid big-padding my-5" bis_skin_checked="1">
                <div class="container-lg py-5" bis_skin_checked="1">
                    <div class="row" bis_skin_checked="1">
                        <div class="col-xl-4 shadow-md rounded login-col bg-white shadow-sm p-5 col-lg-7 col-md-9 mx-auto" bis_skin_checked="1">
                            <div class="mb-4 text-sm text-gray-600" bis_skin_checked="1">
                                هل نسيت كلمة المرور؟ لا مشكلة. فقط أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة تعيين كلمة المرور.
                            </div>
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <!-- حالة الجلسة -->
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <!-- حقل البريد الإلكتروني -->
                                <div class="form-group">
                                    <label for="email">البريد الإلكتروني</label>
                                    <input id="email"
                                        name="email"
                                        type="email"
                                        class="form-control mt-1 @error('email') is-invalid @enderror"
                                        placeholder="أدخل بريدك الإلكتروني"
                                        value="{{ old('email') }}"
                                        required
                                        autofocus>

                                    @error('email')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- زر الإرسال -->
                                <button type="submit" class="btn btn-primary text-light float-end mt-4">
                                    إرسال رابط إعادة تعيين كلمة المرور
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
   
@endsection
