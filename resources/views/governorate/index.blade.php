@extends('layouts.app')
@if(isset($tag))
    @section('title','كل المحافظات')
    {{-- @section('seo_keyword',$tag ->seo_keyword)
    @section('seo_description',$tag ->seo_description)
    @section('seo_url', URL::route('tag.index',$tag ->slug) ) --}}
@endif


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
                <img src="{{ asset('storage/' . $governorate->image) }}" alt="{{ $governorate->name }}" class="img-fluid rounded">
                </div>
                <div class="col-md-8 col-8 my-auto ps-2">
                <div class="card-body">
                <h5 class="card-title">{{ $governorate->name }}</h5>
                <p class="card-text">{{ $governorate->locations_count }} عدد المدن</p>
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