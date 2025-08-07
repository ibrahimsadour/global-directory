@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-20 px-4">
    <div class="w-full max-w-lg bg-white shadow-md rounded-lg overflow-hidden">

        <div class="px-6 py-8">
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">إنشاء حساب شخصي جديد</h2>

            <!-- ✅ التسجيل عبر وسائل التواصل -->
            <div class="flex justify-center space-x-4 rtl:space-x-reverse mb-6">

                <!-- Google -->
                <a href="{{ route('social.redirect.google') }}"
                    class="p-2 rounded text-white bg-red-500 hover:bg-red-600 transition" title="Google">
                    <i class="bi bi-google text-xl"></i>
                </a>

                <!-- Facebook -->
                <a href="{{ route('social.redirect.facebook') }}"
                    class="p-2 rounded text-white bg-blue-700 hover:bg-blue-800 transition" title="Facebook">
                    <i class="bi bi-facebook text-xl"></i>
                </a>

                <!-- Twitter (X) -->
                <a href="{{ route('social.redirect.twitter') }}"
                    class="p-2 rounded text-white bg-gray-800 hover:bg-black transition" title="Twitter / X">
                    <i class="bi bi-twitter-x text-xl"></i>
                </a>

            </div>


            <!-- ✅ فاصل -->
            <div class="my-4 border-t text-center text-gray-900 text-sm">أو سجّل يدويًا</div>

            <!-- ✅ نموذج التسجيل -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- الاسم الكامل -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-900 mb-1">الاسم الكامل</label>
                    <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="أدخل الاسم الكامل" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- البريد الإلكتروني -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-900 mb-1">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="أدخل البريد الإلكتروني" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- رقم الهاتف -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-900 mb-1">رقم الهاتف</label>
                    <div class="flex items-center border border-gray-300 rounded-md shadow-sm focus-within:ring-blue-500 focus-within:border-blue-500 bg-white">
                        
                        <!-- صورة علم الكويت -->
                        <img src="{{ asset('storage/site-settings/kw.webp') }}" alt="علم الكويت" class="w-6 h-4 ml-2 mr-3">

                        <!-- كود الدولة -->
                        <span class="text-gray-500 text-sm pr-2">965+</span>

                        <!-- حقل الهاتف -->
                        <input type="tel" name="phone" id="phone"
                            class="flex-1 border-0 focus:ring-0 focus:outline-none text-sm placeholder-gray-400 py-2 pr-3"
                            placeholder="أدخل رقم الهاتف" value="{{ old('phone') }}" required>
                    </div>
                    @error('phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <!-- كلمة المرور -->
                <div class="mb-4" x-data="{ show: false }">
                    <label for="password" class="block text-sm font-medium text-gray-900 mb-1">كلمة المرور</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" id="password"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 pr-10"
                            placeholder="أدخل كلمة المرور" required>
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-2 flex items-center text-gray-500">
                            <i :class="show ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- تأكيد كلمة المرور -->
                <div class="mb-6" x-data="{ show: false }">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-900 mb-1">تأكيد كلمة المرور</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password_confirmation" id="password_confirmation"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 pr-10"
                            placeholder="أدخل تأكيد كلمة المرور" required>
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-2 flex items-center text-gray-500">
                            <i :class="show ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <!-- زر إنشاء الحساب -->
                <div class="mb-4">
                    <button type="submit"
                        class="w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-900 transition flex items-center justify-center gap-2">
                        <i class="bi bi-person-plus text-lg"></i>
                        إنشاء حساب جديد
                    </button>
                </div>

                <!-- رابط نسيت كلمة المرور -->
                @if (Route::has('password.request'))
                    <div class="text-center mb-2">
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                            نسيت كلمة المرور؟
                        </a>
                    </div>
                @endif

                <!-- رابط تسجيل الدخول -->
                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        لديك حساب بالفعل؟
                        <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">
                            اضغط لتسجيل الدخول
                        </a>
                    </p>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
