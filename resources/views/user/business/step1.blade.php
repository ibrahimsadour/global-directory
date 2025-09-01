@extends('layouts.app')

@section('title', 'لوحة تحكم المستخدم')

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
                <li>لوحة التحكم</li>
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


            <div class="p-6 text-right">
                {{-- عرض الأخطاء --}}
                {{-- @if ($errors->any())
                    <div class="mb-4 p-4 text-red-700 bg-red-100 border border-red-300 rounded">
                        <ul class="list-disc pr-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}

                {{-- النموذج --}}
                <form action="{{ route('user.business.step1.store') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- اسم النشاط --}}
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2">
                            <label for="name" class="w-28 shrink-0 text-sm font-medium text-gray-700">اسم النشاط :</label>
                            <input type="text" name="name" 
                                value="{{ old('name', $data['name'] ?? '') }}"
                                class="flex-1 border rounded-md p-2 focus:ring focus:ring-blue-200" 
                                placeholder="أدخل اسم النشاط التجاري">
                        </div>
                        @error('name')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>




                    {{-- الوصف --}}
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2">
                            <label for="description" class="w-28 shrink-0 text-sm font-medium text-gray-700">الوصف :</label>
                            <textarea name="description" rows="3" 
                                    class="flex-1 border rounded-md p-2 focus:ring focus:ring-blue-200" 
                                    placeholder="اكتب وصفاً قصيراً عن النشاط">{{ old('description', $data['description'] ?? '') }}</textarea>
                        </div>
                        @error('name')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- التصنيف + المحافظة + المدينة --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        {{-- التصنيف --}}
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-2">
                                    <label for="category_id" class="w-28 shrink-0 text-sm font-medium text-gray-700">التصنيف :</label>
                                    <select name="category_id" id="category_id" 
                                            class="w-full border rounded-md focus:ring focus:ring-blue-200">
                                        <option value="" disabled selected hidden>اختر التصنيف</option>
                                        @foreach($categories as $parent)
                                            @if ($parent->children->count())
                                                <optgroup label="{{ $parent->name }}">
                                                    @foreach($parent->children as $child)
                                                        <option value="{{ $child->id }}" 
                                                            {{ old('category_id', $data['category_id'] ?? '') == $child->id ? 'selected' : '' }}>
                                                            {{ $child->name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @else
                                                <option value="{{ $parent->id }}" 
                                                    {{ old('category_id', $data['category_id'] ?? '') == $parent->id ? 'selected' : '' }}>
                                                    {{ $parent->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                            </div>
                            @error('category_id')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- المحافظة --}}
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-2">
                                    <label for="governorate-select" class="w-28 shrink-0 text-sm font-medium text-gray-700">المحافظة :</label>
                                    <select name="governorate_id" id="governorate-select" 
                                            class="w-full border rounded-md focus:ring focus:ring-blue-200">
                                        <option value="" disabled selected hidden>اختر المحافظة</option>
                                        @foreach($governorates as $governorate)
                                            <option value="{{ $governorate->id }}" 
                                                {{ old('governorate_id', $data['governorate_id'] ?? '') == $governorate->id ? 'selected' : '' }}>
                                                {{ $governorate->name }}
                                            </option>
                                        @endforeach
                                    </select>
                            </div>
                            @error('governorate_id')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- المدينة --}}
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-2">
                                    <label for="location-select" class="w-28 shrink-0 text-sm font-medium text-gray-700">المدينة :</label>
                                    <select name="location_id" id="location-select" 
                                            class="w-full border rounded-md focus:ring focus:ring-blue-200">
                                        <option value="" disabled selected hidden>اختر المدينة</option>
                                        @if(!empty($data['location_id']))
                                            <option value="{{ $data['location_id'] }}" selected>
                                                {{ old('location_name', 'المدينة المختارة سابقاً') }}
                                            </option>
                                        @endif
                                    </select>
                            </div>
                            @error('location_id')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>



                    {{-- باقي الحقول (البريد، الهاتف، الموقع، واتساب، العنوان) --}}
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2">
                        <label for="email" class="w-28 shrink-0 text-sm font-medium text-gray-700">البريد الإلكتروني :</label>
                        <input type="email" name="email" value="{{ old('email', $data['email'] ?? '') }}"
                            class="flex-1 border rounded-md p-2 focus:ring focus:ring-blue-200" placeholder="example@mail.com">
                        @error('email')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2">
                        <label for="phone" class="w-28 shrink-0 text-sm font-medium text-gray-700">رقم الهاتف :</label>
                        <input type="text" name="phone" value="{{ old('phone', $data['phone'] ?? '') }}"
                            class="flex-1 border rounded-md p-2 focus:ring focus:ring-blue-200" placeholder="أدخل رقم الهاتف">
                        @error('phone')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2">
                        <label for="website" class="w-28 shrink-0 text-sm font-medium text-gray-700">الموقع الإلكتروني :</label>
                        <input type="text" name="website" value="{{ old('website', $data['website'] ?? '') }}"
                            class="flex-1 border rounded-md p-2 focus:ring focus:ring-blue-200" placeholder="https://">
                        @error('website')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2">
                        <label for="whatsapp" class="w-28 shrink-0 text-sm font-medium text-gray-700">رقم الواتساب :</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $data['whatsapp'] ?? '') }}"
                            class="flex-1 border rounded-md p-2 focus:ring focus:ring-blue-200" placeholder="أدخل رقم الواتساب">
                        @error('whatsapp')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2">
                        <label for="address" class="w-28 shrink-0 text-sm font-medium text-gray-700">العنوان :</label>
                        <textarea name="address" rows="3"
                                class="flex-1 border rounded-md p-2 focus:ring focus:ring-blue-200"
                                placeholder="أدخل عنوان النشاط">{{ old('address', $data['address'] ?? '') }}</textarea>
                        @error('address')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- زر الحفظ --}}
                    <div class="flex justify-end my-4">
                        <button type="submit" 
                            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            {{-- الأيقونة --}}
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
                <p>الخطوة 1 من 3</p>
                <a href="{{ route('user.dashboard') }}" class="text-gray-600 hover:text-blue-600">تخطي والعودة إلى لوحة التحكم</a>
            </div>
        </div>
    </div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const governorateSelect = document.getElementById('governorate-select');
        const locationSelect = document.getElementById('location-select');

        // البيانات من Laravel
        const governorates = @json($governorates);

        governorateSelect.addEventListener('change', function () {
            const governorateId = this.value;
            locationSelect.innerHTML = '<option value=""> اختر المدينة </option>';

            if (governorateId) {
                const selectedGovernorate = governorates.find(g => g.id == governorateId);
                if (selectedGovernorate && selectedGovernorate.locations.length > 0) {
                    selectedGovernorate.locations.forEach(location => {
                        const option = document.createElement('option');
                        option.value = location.id;
                        option.textContent = location.area;
                        locationSelect.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'لا توجد مدن';
                    locationSelect.appendChild(option);
                }
            }
        });
    });
</script>


@endsection

