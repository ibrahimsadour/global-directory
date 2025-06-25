@extends('layouts.app')
@push('meta')
    <meta name="robots" content="noindex, follow">
@endpush
@section('content')
<div class="breadcrumb contaienr-fluid" bis_skin_checked="1">
</div>
<div class="container-fluid single-container">
    <div class="container">
        <div class="row cityrow">
            <h4 class="mb-4">نتائج البحث عن: "{{ $keyword }}"</h4>

            @if($businesses->count() > 0)
                <div class="row">
                    @foreach($businesses as $business)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="{{ $business->image ? asset('storage/' . $business->image) : 'https://via.placeholder.com/300' }}"
                                    class="card-img-top" alt="{{ $business->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $business->name }}</h5>
                                    <p class="card-text text-truncate">{{ $business->description }}</p>
                                    <a href="{{ route('business.show', $business->slug) }}" class="btn btn-outline-primary btn-sm">عرض التفاصيل</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $businesses->withQueryString()->links('vendor.pagination.custom-bootstrap') }}
            @else
            <p>لا توجد نتائج مطابقة لبحثك.</p>
            @endif
        </div>
    </div>
</div>
@endsection

