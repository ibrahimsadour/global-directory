@extends('layouts.app')

@push('meta')
    {{-- نستخدم robots=noindex, follow للحفاظ على ترتيب صفحات الأعمال الفردية --}}
    <meta name="robots" content="noindex, follow">
@endpush

@section('content')

{{-- 1. إضافة شريط التنقل (Breadcrumb) لتعزيز تجربة المستخدم --}}
<div class="breadcrumb container-fluid">

</div>

<div class="container container-fluid single-container mt-4">
    <div class="row">
        {{-- عنوان الصفحة وعدد النتائج --}}
        <div class="col-12">
            @if($businesses->total() > 0)
                <h4 class="mb-4">
                    نتائج البحث عن: **"{{ $keyword }}"**
                    <span class="badge bg-primary fs-6">{{ $businesses->total() }} نتائج</span>
                </h4>
            @else
                 <h4 class="mb-4">نتائج البحث عن: **"{{ $keyword }}"**</h4>
            @endif
        </div>
        
        <div class="col-12">
            @if($businesses->count() > 0)
                <div class="row">
                    @foreach($businesses as $business)
                        <div class="col-lg-4 col-md-6 mb-4">
                            {{-- إضافة تأثير حركة عند مرور الماوس (hover) وتحسين الظل --}}
                            <div class="card business-card h-100 shadow-lg border-0 transition-3d-hover overflow-hidden">
                                
                                @php
                                    // معالجة الصورة الافتراضية
                                    $defaultImageUrl = asset('storage/business_photos/default.webp');
                                    $imageUrl = $business->image ? asset('storage/' . $business->image) : $defaultImageUrl;
                                @endphp
                                
                                {{-- قسم الصورة --}}
                                <div class="position-relative">
                                    <a href="{{ route('business.show', $business->slug) }}" title="عرض {{ $business->name }}">
                                        <img class="card-img-top business-img object-fit-cover" 
                                            src="{{ $imageUrl }}" 
                                            alt="{{ $business->name }}" 
                                            loading="lazy" 
                                            style="height: 200px;" /> {{-- تثبيت ارتفاع الصورة --}}
                                    </a>
                                    
                                    {{-- مثال: إضافة شارة لحالة النشاط التجاري (اختياري) --}}
                                    @if($business->is_featured ?? false)
                                    <span class="badge bg-success position-absolute top-0 start-0 m-2">مُميز</span>
                                    @endif
                                </div>

                                {{-- قسم المحتوى --}}
                                <div class="card-body d-flex flex-column p-4">
                                    
                                    {{-- العنوان --}}
                                    <h5 class="card-title fw-bold mb-2">
                                        <a href="{{ route('business.show', $business->slug) }}" class="text-decoration-none text-dark hover-primary">
                                            {{ Str::limit($business->name, 50) }}
                                        </a>
                                    </h5>
                                    
                                    {{-- معلومات الموقع (إذا كانت متوفرة) --}}
                                    {{-- افتراضاً أن لديك حقل city_name أو category_name --}}
                                    @if($business->city ?? false)
                                        <small class="text-primary mb-2 d-block">
                                            <i class="bi bi-geo-alt-fill me-1"></i> {{ $business->city->name ?? $business->city_name }}
                                        </small>
                                    @endif
                                    
                                    {{-- الوصف (متعدد الأسطر ويستهلك المساحة المتاحة) --}}
                                    {{-- text-truncate-3 هو كلاس مخصص افتراضي يحد من 3 أسطر --}}
                                    <p class="card-text text-muted text-truncate-3 flex-grow-1 mb-3" style="min-height: 4.5em;">
                                        {{ Str::limit($business->description, 100) ?: 'لا يوجد وصف مفصل متاح لهذا النشاط التجاري.' }}
                                    </p>
                                    
                                    {{-- زر التفاصيل (مثبت في الأسفل) --}}
                                    <div class="mt-auto"> {{-- mt-auto يدفع العنصر للأسفل ضمن flexbox --}}
                                        <a href="{{ route('business.show', $business->slug) }}" class="btn btn-outline-primary w-100 fw-bold">
                                            عرض التفاصيل <i class="bi bi-arrow-left me-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            {{-- عرض روابط التنقل (Pagination) --}}
            {{-- my-5 يضيف هامش علوي وسفلي (عادةً 3rem) لضمان تباعد جيد عن الفوتر --}}
            <div class="d-flex justify-content-center py-4 my-5 bg-light rounded-3"> 
                {{ $businesses->withQueryString()->links('vendor.pagination.custom-bootstrap') }}
            </div>

            {{-- ملاحظة: إذا كنت تستخدم تصميم داكن، استبدل bg-light بـ bg-white أو حسب الكلاسات المتوفرة لديك. --}}
            
            @else
                {{-- رسالة عدم وجود نتائج --}}
                <div class="alert alert-warning text-center p-5 my-5" role="alert">
                    <h5 class="alert-heading">عفواً، لا توجد نتائج! 😔</h5>
                    <p>لم نجد أي أنشطة تجارية مطابقة لبحثك: **"{{ $keyword }}"**.</p>
                    <hr>
                    <p class="mb-0">يرجى المحاولة باستخدام كلمات بحث مختلفة أو أعم. </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection