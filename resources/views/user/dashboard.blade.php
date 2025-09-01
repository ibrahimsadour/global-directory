@extends('layouts.app')
@section('title', 'لوحة تحكم المستخدم')

@section('content')
    <section class="nav-container user-page-nav container-fluid">
        <div class="container">
            {{-- breadcrumb --}}
            <div class="row">
                <ul class="path">
                    <li><a href="{{ route('user.dashboard') }}">الرئيسية <i class="bi bi-arrow-left-short"></i></a></li>
                    <li> لوحة التحكم </li>
                </ul>
            </div>

            {{-- ✅ هنا نضيف رسائل الفلاش --}}
            @if(session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </section>



    <div class="container-fluid user-container">
       <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <x-user.navigation />
                </div>
                <div class="col-md-9">
                <div class="user-info">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="user-widg">
                                <div class="icon">
                                    <i class="bi bi-card-checklist"></i>
                                </div>
                                <div class="detail">
                                <h6>{{ $activeBusinesses }}</h6>
                                <p>عدد الاعلانات النشطة</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="user-widg">
                                <div class="icon">
                                    <i class="bi bi-star-half"></i>
                                </div>
                                <div class="detail">
                                <h6>{{ $totalReviews }}</h6>
                                <p>إجمالي عدد التقيمات</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="user-widg">
                                <div class="icon">
                                    <i class="bi bi-chat-left-text"></i>
                                </div>
                                <div class="detail">
                                <h6>66</h6>
                                <p>عدد الرسائل</p>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                   
                </div>
<div class="latest-reviews business-listing">
    @forelse($latestBusinesses as $business)
        <div class="row shadow-sm list-row border rounded mb-3">
            <div class="col-lg-4 pe-0 img-col">
                <a href="{{ route('business.show', $business->id) }}">
                    <img class="rounded w-100 h-100 object-cover" 
                         src="{{ $business->image ? asset('storage/' . $business->image) : asset('assets/images/default.jpg') }}" 
                         alt="{{ $business->name }}">
                </a>
            </div>
            <div class="col-lg-8 detail-col">
                <a href="{{ route('business.show', $business->id) }}">
                    <div class="bofy-col">
                        <h2 class="text-truncate">{{ $business->name }}</h2>
                        <p>{{ Str::limit($business->description, 120) }}</p>
                        <ul class="row ms-1">
                            <li class="col-md-4"><i class="bi bi-telephone"></i> {{ $business->phone ?? '-' }}</li>
                            <li class="col-md-8"><i class="bi bi-envelope"></i> {{ $business->email ?? '-' }}</li>
                        </ul>
                        <ul class="row ms-1">
                            <li class="col-md-4"><i class="bi bi-map"></i> {{ $business->governorate->name ?? '' }}</li>
                            <li class="col-md-8">
                                <p class="text-truncate">
                                    <i class="bi bi-geo-alt"></i> {{ $business->address ?? '-' }}
                                </p>
                            </li>
                        </ul>
                    </div>
                </a>

                <div class="footcover pe-0">
                    <ul class="d-flex justify-content-between align-items-center list-unstyled m-0 p-0">
                        <li class="rev d-flex align-items-center gap-1">
                            {{-- عرض النجوم --}}
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= $business->average_rating ? 'bi-star-fill act' : 'bi-star' }}"></i>
                            @endfor
                            <small>{{ $business->average_rating }} ({{ $business->local_reviews_count }} تقييم)</small>
                        </li>

                        <li class="actionlist d-flex align-items-center gap-2">
                            {{-- زر الحذف --}}
                            <form action="" method="POST" class="m-0 p-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center"
                                    onclick="return confirm('هل أنت متأكد من الحذف؟');">
                                    <i class="bi bi-trash3"></i> حذف
                                </button>
                            </form>

                            {{-- زر التعديل --}}
                            <a href="" 
                            class="btn btn-sm btn-primary d-flex align-items-center">
                                <i class="bi bi-pencil-square"></i> تعديل
                            </a>
                        </li>
                    </ul>
                </div>


            </div>
        </div>
    @empty
        <p class="text-center text-gray-500">لا توجد إعلانات بعد.</p>
    @endforelse
</div>


            </div>
       </div>
    </div>
@endsection
