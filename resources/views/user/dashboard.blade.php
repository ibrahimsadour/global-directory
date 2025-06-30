@extends('layouts.app')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 4000)"
    x-show="show"
    x-transition
    class="fixed top-1/4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white text-center px-6 py-4 rounded-lg shadow-lg z-50 w-full max-w-md"
    style="display: none;"
>
    {{ session('success') ?? session('error') ?? '' }}
</div>

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
        </div>
    </section>

    @if(session('success') || session('error'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 4000)"
            x-show="show"
            x-transition
            class="fixed top-1/4 left-1/2 transform -translate-x-1/2 bg-white text-gray-800 border border-green-500 shadow-lg text-center px-6 py-4 rounded-lg z-50 w-full max-w-md"
            style="display: none;"
        >
            <div class="font-bold text-lg mb-2">
                {{ session('success') ? '✅ نجاح' : '❌ خطأ' }}
            </div>
            <div>
                {{ session('success') ?? session('error') }}
            </div>
        </div>
    @endif

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
                                <h6>12,453</h6>
                                <p>Total Active Listing</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="user-widg">
                                <div class="icon">
                                    <i class="bi bi-star-half"></i>
                                </div>
                                <div class="detail">
                                <h6>8,453</h6>
                                <p>Total Reviews</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="user-widg">
                                <div class="icon">
                                    <i class="bi bi-chat-left-text"></i>
                                </div>
                                <div class="detail">
                                <h6>153</h6>
                                <p>New Messages</p>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                   
                </div>
                <div class="latest-reviews business-listing">
                    <div class="row shadow-sm list-row border rounded">
                        <div class="col-lg-4 pe-0 img-col">
                            <img class="rounded" src="{{ asset('assets/images/listing/l-7.jpg') }}" alt="">
                        </div>
                        <div class="col-lg-8 detail-col">
                            <div class="bofy-col">
                                <h2 class="text-truncate">South Indian Restuarent</h2>
                                <p class="text-truncate">We provide Quality South Indian Foods. Visit our Restuarent with your Family to get an awesome experiance</p>
                                <ul>
                                    <li><i class="bi bi-telephone"></i> +61-8281-153</li>
                                    <li><i class="bi bi-envelope"></i> kalaiunavagam@gmail.com</li>

                                </ul>
                                <ul>
                                    <li> <i class="bi bi-map"></i> New York</li>
                                    <li><i class="bi bi-geo-alt"></i>  Mig-213 Modern Colorny, NY 10012</li>
                                </ul>
                            </div>
                        
                            <div class="footcover pe-0">
                                <ul>
                                    <li class="rev"> 
                                        <i class="bi act bi-star-fill"></i>
                                        <i class="bi act bi-star-fill"></i>
                                        <i class="bi act bi-star-fill"></i>
                                        <i class="bi act bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <small>4.5  (12 Reviews)</small>
                                    </li>
                                    <li class="actionlist">
                                        <button type="button" class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i> Danger</button>
                                        <button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row shadow-sm list-row border rounded">
                        <div class="col-lg-4 pe-0 img-col">
                            <img class="rounded" src="{{ asset('assets/images/listing/l-7.jpg') }}" alt="">
                        </div>
                        <div class="col-lg-8 detail-col">
                            <div class="bofy-col">
                                <h2 class="text-truncate">South Indian Restuarent</h2>
                                <p class="text-truncate">We provide Quality South Indian Foods. Visit our Restuarent with your Family to get an awesome experiance</p>
                                <ul>
                                    <li><i class="bi bi-telephone"></i> +61-8281-153</li>
                                    <li><i class="bi bi-envelope"></i> kalaiunavagam@gmail.com</li>

                                </ul>
                                <ul>
                                    <li> <i class="bi bi-map"></i> New York</li>
                                    <li><i class="bi bi-geo-alt"></i>  Mig-213 Modern Colorny, NY 10012</li>
                                </ul>
                            </div>
                        
                            <div class="footcover pe-0">
                                <ul>
                                    <li class="rev"> 
                                        <i class="bi act bi-star-fill"></i>
                                        <i class="bi act bi-star-fill"></i>
                                        <i class="bi act bi-star-fill"></i>
                                        <i class="bi act bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <small>4.5  (12 Reviews)</small>
                                    </li>
                                    <li class="actionlist">
                                        <button type="button" class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i> Danger</button>
                                        <button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </div>
@endsection
