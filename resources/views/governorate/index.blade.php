@extends('layouts.app')
@section('title',setting('site_title').' - كل المحافظات')
@section('seo_keyword',setting('seo_meta_keywords'))
@section('seo_description',setting('seo_meta_description'))
@section('og:image', asset('storage/site-settings/default-banner.webp'))


@section('content')

{{-- breadcrumb --}}
<x-breadcrumb :items="[
    ['title' => 'الرئيسية', 'url' => url('/')],
    ['title' => 'كل المحافظات', 'url' => route('governorates.index')],
]" />

{{-- Begin Second section --}}
<div class="container-fluid featured-city">
   <div class="container">
      <div class="row cityrow">

        @foreach($governorates as $governorate)
            <div class="col-lg-3 col-md-4 col-sm-6 citycol">
                <a href="#">
                    <div class="citycover">
                <a href="{{ route('governorates.show', $governorate->slug) }}">
                <div class="row g-0">
                <div class="col-md-4 col-4">
                @if(!empty($governorate->image))
                    <img src="{{ asset('storage/' . $governorate->image) }}" alt="{{ $governorate->name }}" class="img-fluid rounded">
                @endif
                </div>
                <div class="col-md-8 col-8 my-auto ps-2">
                <div class="card-body">
                @if(!empty($governorate->name))
                <h5 class="card-title">{{ $governorate->name }}</h5>
                @endif
                @if(!empty($governorate->locations_count))
                <p class="card-text">{{ $governorate->locations_count }} عدد المدن</p>
                @endif
                </div>
                </div>
                </div>
                </a>
                </div>
                </a>
            </div>
        @endforeach 
      </div>
   </div>
</div>
{{-- End Second section --}}
@endsection