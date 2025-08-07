@extends('layouts.app')
@section('content')

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-10 px-4">
    <div class="w-full max-w-md bg-white shadow-md rounded-lg overflow-hidden">

        <div class="px-6 py-8">
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">تسجيل دخول المستخدم</h2>


            <!-- تسجيل دخول عبر وسائل التواصل -->
            <div class="flex justify-center space-x-4 rtl:space-x-reverse mt-6">
                <!-- Google -->
                <a href="{{ route('social.redirect.google') }}"
                    class="p-2 rounded text-white bg-red-500 hover:bg-red-600 transition" title="Google">
                    <i class="bi bi-google"></i>
                </a>

                <!-- Facebook -->
                <a href="{{ route('social.redirect.facebook') }}"
                    class="p-2 rounded text-white bg-blue-900 hover:bg-blue-800 transition" title="Facebook">
                    <i class="bi bi-facebook text-xl"></i>
                </a>

                <!-- Twitter / X -->
                <a href="{{ route('social.redirect.twitter') }}"
                    class="p-2 rounded text-white bg-gray-800 hover:bg-black transition" title="Twitter / X">
                    <i class="bi bi-twitter-x text-xl"></i>
                </a>
            </div>
            
            <div class="my-4 border-t text-center text-blue-900 text-sm">أو سجّل يدويًا</div>

            @if (session('error'))
                <div class="mb-4 bg-red-100 text-red-900 text-sm p-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- البريد الإلكتروني أو رقم الهاتف -->
                <div class="mb-4">
                    <label for="login" class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني أو رقم الهاتف</label>
                    <input id="login" type="text" name="login" value="{{ old('login') }}"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="أدخل البريد أو رقم الهاتف" required>
                    @error('login')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- كلمة المرور -->
                <div class="mb-4" x-data="{ show: false }">
                    <label for="password" class="block text-sm font-medium text-gray-900 mb-1 font-semibold">كلمة المرور</label>

                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" id="password"
                            class="w-full border border-gray-300 rounded-md shadow-sm pr-10 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="أدخل كلمة المرور" required>

                                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-2 flex items-center text-gray-500">
                                            <i :class="show ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                                        </button>
                    </div>

                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>



                <!-- تذكرني -->
                <div class="flex items-center mb-4">
                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-blue-900 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">تذكرني</label>
                </div>

                <!-- زر تسجيل الدخول -->
                <div class="mb-4">
                    <button type="submit"
                        class="w-full bg-blue-900 text-white py-2 px-4 rounded hover:bg-blue-900 transition flex items-center justify-center gap-2">
                        تسجيل الدخول
                        <i class="bi bi-box-arrow-in-left text-lg"></i>
                    </button>

                </div>

                <!-- نسيت كلمة المرور -->
                @if (Route::has('password.request'))
                    <div class="text-center mb-2">
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-900 hover:underline">
                            هل نسيت كلمة المرور؟
                        </a>
                    </div>
                @endif

                <!-- رابط التسجيل -->
                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        لا تملك حساباً؟
                        <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">
                            أنشئ حساب جديد
                        </a>
                    </p>
                </div>
            </form>

        </div>
    </div>
</div>


@endsection
