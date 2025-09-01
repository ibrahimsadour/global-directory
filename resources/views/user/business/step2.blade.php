@extends('layouts.app')

@section('title', 'إضافة الشعار والمعرض')

@section('content')
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
            <li>إضافة الشعار</li>
        </ul>
    </div>
</section>

<div class="max-w-5xl mx-auto py-8 px-4">
    <div class="bg-white rounded-xl shadow text-center overflow-hidden">

        {{-- التبويبات --}}
        <div class="border-b">
            <ul class="flex flex-wrap text-sm font-medium text-gray-500 text-center">
                <li class="flex-1">
                    <a href="{{ route('user.business.step1') }}" 
                    class="block py-3 px-4 
                    {{ request()->routeIs('user.business.step1') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100' }}">
                        البيانات الأساسية
                    </a>
                </li>
                <li class="flex-1">
                    <a href="{{ route('user.business.step2') }}" 
                    class="block py-3 px-4 
                    {{ request()->routeIs('user.business.step2') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100' }}">
                        إضافة الشعار
                    </a>
                </li>
                <li class="flex-1">
                    <a href="{{ route('user.business.step3') }}" 
                    class="block py-3 px-4 
                    {{ request()->routeIs('user.business.step3') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100' }}">
                        أوقات الدوام والتواصل
                    </a>
                </li>
            </ul>
        </div>


        <div class="p-6 text-right bg-cyan-50">
            {{-- نموذج رفع الصور --}}
            <form action="{{ route('user.business.step2.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- رفع الشعار --}}
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-2 w-full">
                        <label for="image" class="w-24 shrink-0 text-sm font-medium text-gray-700">الشعار :</label>

                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <input type="file" name="image" id="image"
                                class="flex-1 min-w-0 border rounded-md p-2 focus:ring focus:ring-blue-200">

                            @if(!empty($data['image']))
                                <img src="{{ asset('storage/' . $data['image']) }}" 
                                    class="h-12 w-12 object-cover rounded-md border flex-shrink-0" 
                                    alt="الشعار الحالي">
                            @endif
                        </div>
                    </div>

                    @error('image')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>



                {{-- رفع صور المعرض --}}
                <div class="flex flex-col gap-1">
                    <div class="flex items-start gap-2 w-full">
                        <label for="gallery" class="w-24 shrink-0 text-sm font-medium text-gray-700">المعرض :</label>

                        <div class="flex items-start gap-3 flex-1 min-w-0 flex-wrap">
                            <input type="file" name="gallery[]" id="gallery" multiple
                                class="flex-1 min-w-0 border rounded-md p-2 focus:ring focus:ring-blue-200">

                            @if(!empty($data['gallery']) && is_array($data['gallery']))
                                <div class="flex gap-2 flex-wrap flex-shrink-0">
                                    @foreach($data['gallery'] as $img)
                                        <img src="{{ asset('storage/' . $img) }}" 
                                            class="h-12 w-12 object-cover rounded-md border" 
                                            alt="صورة من المعرض">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    @error('gallery')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- أزرار التنقل --}}
                <div class="flex justify-between my-4">
                    <a href="{{ route('user.business.step1') }}" 
                        class="flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        رجوع
                    </a>

                    <button type="submit" 
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" 
                            class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M5 13l4 4L19 7" />
                        </svg>
                        حفظ ومتابعة
                    </button>
                </div>
            </form>

        </div>

        {{-- الفوتر --}}
        <div class="bg-gray-50 border-t px-6 py-3 flex justify-between text-sm text-gray-600">
            <p>الخطوة 2 من 3</p>
            <a href="{{ route('user.dashboard') }}" class="text-gray-600 hover:text-blue-600">تخطي والعودة إلى لوحة التحكم</a>
        </div>
    </div>
</div>
@endsection
