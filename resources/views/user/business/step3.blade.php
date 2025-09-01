@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@section('title', 'إضافة نشاط - أوقات الدوام وروابط التواصل')

@section('content')
    {{-- breadcrumb --}}
    <section class="bg-gray-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <ul class="flex items-center space-x-2 rtl:space-x-reverse text-sm text-gray-600">
                <li>
                    <a href="{{ route('user.dashboard') }}" class="text-blue-600 hover:underline flex items-center">
                        الرئيسية
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                </li>
                <li>إضافة نشاط</li>
                <li>الخطوة 3</li>
            </ul>
        </div>
    </section>

    <div class="max-w-5xl mx-auto py-8 px-4">
        <div class="bg-white rounded-xl shadow overflow-hidden">

            {{-- التبويبات --}}
            <div class="border-b">
                <ul class="flex flex-wrap justify-between text-sm font-medium text-gray-500 text-center">
                    <li class="flex-1"><span class="block py-3 px-4">البيانات الأساسية</span></li>
                    <li class="flex-1"><span class="block py-3 px-4">إضافة الشعار</span></li>
                    <li class="flex-1"><span class="block py-3 px-4 bg-blue-600 text-white">أوقات الدوام والتواصل</span></li>
                </ul>
            </div>

            <div class="p-6 text-right">
                {{-- عرض الأخطاء --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 text-red-700 bg-red-100 border border-red-300 rounded">
                        <ul class="list-disc pr-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- النموذج --}}
                <form action="{{ route('user.business.step3.store') }}" method="POST" class="space-y-8">
                    @csrf

                    {{-- أوقات الدوام --}}
                    <div>
                        <h2 class="font-bold text-lg mb-4">أوقات الدوام</h2>
                        @php
                            $days = [
                                'saturday' => 'السبت',
                                'sunday' => 'الأحد',
                                'monday' => 'الاثنين',
                                'tuesday' => 'الثلاثاء',
                                'wednesday' => 'الأربعاء',
                                'thursday' => 'الخميس',
                                'friday' => 'الجمعة',
                            ];

                            $hours = range(1, 12);
                            $periods = ['AM' => 'صباحاً', 'PM' => 'مساءً'];
                            $savedHours = $data['step3']['hours'] ?? [];
                        @endphp

                        <div class="space-y-3">
                            @foreach($days as $key => $label)
                                @php
                                    $dayData = collect($savedHours)->firstWhere('day', $key) ?? [];
                                @endphp

                                <div class="grid grid-cols-12 items-center gap-2">
                                    {{-- اليوم --}}
                                    <span class="col-span-2 text-gray-700 text-sm">{{ $label }}</span>

                                    {{-- وقت الفتح --}}
                                    <div class="col-span-4 flex gap-2">
                                        <select name="hours[{{ $loop->index }}][open_hour]"
                                            class="appearance-none border rounded-md text-sm flex-[1] px-2 py-1 focus:ring focus:ring-blue-200"
                                            style="background-image: none !important;">
                                            <option value="">من</option>
                                            @foreach($hours as $h)
                                                <option value="{{ $h }}" {{ old("hours.$loop->index.open_hour", $dayData['open_hour'] ?? '') == $h ? 'selected' : '' }}>
                                                    {{ $h }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <select name="hours[{{ $loop->index }}][open_period]"
                                            class="appearance-none border rounded-md text-sm flex-[2] px-2 py-1 focus:ring focus:ring-blue-200"
                                            style="background-image: none !important;">
                                            @foreach($periods as $val => $labelPeriod)
                                                <option value="{{ $val }}" {{ old("hours.$loop->index.open_period", $dayData['open_period'] ?? '') == $val ? 'selected' : '' }}>
                                                    {{ $labelPeriod }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <span class="col-span-1 text-center text-gray-500">-</span>

                                    {{-- وقت الإغلاق --}}
                                    <div class="col-span-4 flex gap-2">
                                        <select name="hours[{{ $loop->index }}][close_hour]"
                                            class="appearance-none border rounded-md text-sm flex-[1] px-2 py-1 focus:ring focus:ring-blue-200"
                                            style="background-image: none !important;">
                                            <option value="">إلى</option>
                                            @foreach($hours as $h)
                                                <option value="{{ $h }}" {{ old("hours.$loop->index.close_hour", $dayData['close_hour'] ?? '') == $h ? 'selected' : '' }}>
                                                    {{ $h }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <select name="hours[{{ $loop->index }}][close_period]"
                                            class="appearance-none border rounded-md text-sm flex-[2] px-2 py-1 focus:ring focus:ring-blue-200"
                                            style="background-image: none !important;">
                                            @foreach($periods as $val => $labelPeriod)
                                                <option value="{{ $val }}" {{ old("hours.$loop->index.close_period", $dayData['close_period'] ?? '') == $val ? 'selected' : '' }}>
                                                    {{ $labelPeriod }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <input type="hidden" name="hours[{{ $loop->index }}][day]" value="{{ $key }}">
                                </div>

                            @endforeach
                        </div>
                        @error('hours')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- روابط التواصل --}}
                    <div>
                        <h2 class="font-bold text-lg mb-4">روابط التواصل الاجتماعي</h2>
                        <div class="space-y-3">

                            {{-- Facebook --}}
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-600">
                                    <i class="fab fa-facebook-f"></i>
                                </span>
                                <input type="url" name="facebook" placeholder="رابط فيسبوك" 
                                    value="{{ old('facebook', $data['step3']['facebook'] ?? '') }}"
                                    class="w-full border rounded-md p-2 pl-10">
                            </div>
                            @error('facebook')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            {{-- Instagram --}}
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-pink-500">
                                    <i class="fab fa-instagram"></i>
                                </span>
                                <input type="url" name="instagram" placeholder="رابط إنستجرام"
                                    value="{{ old('instagram', $data['step3']['instagram'] ?? '') }}"
                                    class="w-full border rounded-md p-2 pl-10">
                            </div>
                            @error('instagram')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            {{-- Twitter / X --}}
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-sky-500">
                                    <i class="fab fa-twitter"></i>
                                </span>
                                <input type="url" name="twitter" placeholder="رابط تويتر"
                                    value="{{ old('twitter', $data['step3']['twitter'] ?? '') }}"
                                    class="w-full border rounded-md p-2 pl-10">
                            </div>
                            @error('twitter')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            {{-- Linkedin --}}
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-700">
                                    <i class="fab fa-linkedin-in"></i>
                                </span>
                                <input type="url" name="linkedin" placeholder="رابط لينكدإن"
                                    value="{{ old('linkedin', $data['step3']['linkedin'] ?? '') }}"
                                    class="w-full border rounded-md p-2 pl-10">
                            </div>
                            @error('linkedin')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            {{-- YouTube --}}
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-red-600">
                                    <i class="fab fa-youtube"></i>
                                </span>
                                <input type="url" name="youtube" placeholder="رابط يوتيوب"
                                    value="{{ old('youtube', $data['step3']['youtube'] ?? '') }}"
                                    class="w-full border rounded-md p-2 pl-10">
                            </div>
                            @error('youtube')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            {{-- TikTok --}}
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-black">
                                    <i class="fab fa-tiktok"></i>
                                </span>
                                <input type="url" name="tiktok" placeholder="رابط تيك توك"
                                    value="{{ old('tiktok', $data['step3']['tiktok'] ?? '') }}"
                                    class="w-full border rounded-md p-2 pl-10">
                            </div>
                            @error('tiktok')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                        </div>
                    </div>



                    {{-- أزرار التنقل --}}
                    <div class="flex justify-between my-4">
                        <a href="{{ route('user.business.step2') }}" 
                            class="flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            رجوع
                        </a>

                        <button type="submit" 
                            class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            حفظ النشاط
                        </button>
                    </div>
                </form>



            </div>

            {{-- الفوتر --}}
            <div class="bg-gray-50 border-t px-6 py-3 flex justify-between text-sm text-gray-600">
                <p>الخطوة 3 من 7</p>
                <a href="{{ route('user.dashboard') }}" class="text-gray-600 hover:text-blue-600">تخطي والعودة إلى لوحة التحكم</a>
            </div>
        </div>
    </div>
@endsection
