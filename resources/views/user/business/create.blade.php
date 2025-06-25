@extends('layouts.app')

@section('title', 'لوحة تحكم المستخدم')

@section('content')
<section class="nav-container user-page-nav container-fluid">
  <div class="container">

    {{-- breadcrumb --}}
    <div class="row">
      <ul class="path">
        <li><a href="{{route('user.dashboard')}}">الرئيسية <i class="bi bi-arrow-left-short"></i></a></li>
        <li> لوحة التحكم </li>
      </ul>
    </div>
    
  </div>
</section>
<div class="container">
    <div class="row new-listing">
        <div class="col-md-10 p-0 listing-col mx-auto">
            <div class="card shadow text-center">
                <div class="card-header p-0">
                    <ul class="nav nav-pills nav-fill">
                        <li class="nav-item"><a class="nav-link disabled active">البيانات الأساسية</a></li>
                        <li class="nav-item"><a class="nav-link">إضافة الشعار</a></li>
                        <li class="nav-item"><a class="nav-link">حول النشاط</a></li>
                        <li class="nav-item"><a class="nav-link">الخدمات</a></li>
                        <li class="nav-item"><a class="nav-link">المنتجات</a></li>
                        <li class="nav-item"><a class="nav-link">المعرض</a></li>
                        <li class="nav-item"><a class="nav-link">تفاصيل إضافية</a></li>
                    </ul>
                </div>
                <div class="card-body tab-content p-0">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div id="v-pills-basic" class="form-container show active tab-pane">
                    <form action="{{ route('user.business.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="row form-row">
                                <div class="col-md-2"><label for="name">اسم النشاط</label></div>
                                <div class="col-md-6"><input type="text" name="name" class="form-control" placeholder="أدخل اسم النشاط التجاري" value="{{ old('name') }}"></div>
                            </div>
                            <div class="row form-row">
                                <div class="col-md-2"><label for="description">الوصف</label></div>
                                <div class="col-md-6">
                                    <textarea name="description" class="form-control" placeholder="اكتب وصفاً قصيراً عن النشاط">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="row form-row">
                                {{-- التصنيف --}}
                                <div class="col-md-4 d-flex align-items-center position-relative">
                                    <label for="category_id" class="me-2 mb-0" style="white-space: nowrap;">اختر التصنيف:</label>

                                    <div style="position: relative; width: 100%;">
                                        <svg style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); pointer-events: none;" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="dropdown-heading-dropdown-arrow gray">
                                            <path d="M6 9L12 15 18 9"></path>
                                        </svg>

                                        <select name="category_id" class="form-control ps-5" style="appearance: none; -webkit-appearance: none; -moz-appearance: none;">
                                            <option value="">-- اختر التصنيف --</option>
                                            @foreach($categories as $parent)
                                                @if ($parent->children->count())
                                                    <optgroup label="{{ $parent->name }}">
                                                        @foreach($parent->children as $child)
                                                            <option value="{{ $child->id }}">{{ $child->name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @else
                                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- المحافظة --}}
                                <div class="col-md-4 d-flex align-items-center position-relative">
                                    <label for="governorate" class="me-2 mb-0" style="white-space: nowrap;">اختر المحافظة</label>

                                    <div style="position: relative; width: 100%;">
                                        <svg style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); pointer-events: none;" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="dropdown-heading-dropdown-arrow gray">
                                            <path d="M6 9L12 15 18 9"></path>
                                        </svg>

                                        <select name="governorate_id" id="governorate-select" class="form-control ps-5" style="appearance: none; -webkit-appearance: none; -moz-appearance: none;">
                                            <option value="">-- اختر المحافظة --</option>
                                            @foreach($governorates as $governorate)
                                                <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                {{-- المدينة --}}
                                <div class="col-md-4 d-flex align-items-center position-relative">
                                    <label for="location_id" class="me-2 mb-0" style="white-space: nowrap;">اختر المدينة</label>

                                    <div style="position: relative; width: 100%;">
                                        <svg style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); pointer-events: none;" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="dropdown-heading-dropdown-arrow gray">
                                            <path d="M6 9L12 15 18 9"></path>
                                        </svg>

                                        <select name="location_id" id="location-select" class="form-control ps-5" style="appearance: none; -webkit-appearance: none; -moz-appearance: none;">
                                            <option value="">-- اختر المدينة --</option>
                                            {{-- سيتم تعبئتها تلقائياً --}}
                                        </select>
                                    </div>
                                </div>


                            </div>


                            <div class="row form-row">
                                <div class="col-md-2"><label for="email">البريد الإلكتروني</label></div>
                                <div class="col-md-4"><input type="email" name="email" class="form-control" placeholder="أدخل البريد الإلكتروني" value="{{ old('email') }}"></div>
                                <div class="col-md-2"><label for="phone">رقم الهاتف</label></div>
                                <div class="col-md-4"><input type="text" name="phone" class="form-control" placeholder="أدخل رقم الهاتف" value="{{ old('phone') }}"></div>
                            </div>
                            <div class="row form-row">
                                <div class="col-md-2"><label for="website">الموقع الإلكتروني</label></div>
                                <div class="col-md-4"><input type="text" name="website" class="form-control" placeholder="https://" value="{{ old('website') }}"></div>
                                <div class="col-md-2"><label for="whatsapp">رقم الواتساب</label></div>
                                <div class="col-md-4"><input type="text" name="whatsapp" class="form-control" placeholder="أدخل رقم الواتساب" value="{{ old('whatsapp') }}"></div>
                            </div>
                            <div class="row form-row">
                                <div class="col-md-2"><label for="address">العنوان</label></div>
                                <div class="col-md-4">
                                    <textarea name="address" rows="3" class="form-control" placeholder="أدخل عنوان النشاط">{{ old('address') }}</textarea>
                                </div>
                            </div>
                            <div class="row form-row">
                                <div class="col-md-2"></div>
                                <div class="col-md-4"><button type="submit" class="btn btn-primary">حفظ ومتابعة</button></div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col-md-6 pt-2 text-start"><p>الخطوة 1 من 7</p></div>
                        <div class="col-md-6 text-end"><a href="{{ route('user.dashboard') }}" class="btn btn-light">تخطي والعودة إلى لوحة التحكم</a></div>
                    </div>
                </div>
            </div>
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
            locationSelect.innerHTML = '<option value="">-- اختر المدينة --</option>';

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

