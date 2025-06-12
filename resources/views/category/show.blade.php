@extends('layouts.app')
@if(isset($category))
    @section('title',$category->name)
    {{-- @section('seo_keyword',$tag ->seo_keyword)
    @section('seo_description',$tag ->seo_description)
    @section('seo_url', URL::route('tag.index',$tag ->slug) ) --}}
@endif


@section('content')

{{-- breadcrumb --}}
<x-breadcrumb :items="[
    ['title' => 'الرئيسية', 'url' => url('/')],
    ['title' => 'كل الفئات', 'url' => route('categories.index')],
    ['title' => $category->name]
]" />

{{-- Begin Second section --}}
<div class="container-fluid business-listing">
   <div class="container">
      <div class="row">
         <div class="col-lg-3 col-md-4 filtercover">
            <div class="filter-col shadow-sm">
               <div  class="category-filterr">
                  <div x-data="{cfilter}" class="filter-head">
                     <h2>تصفية حسب الفئات <i @click="filterCat()" class="bi cp float-end bi-funnel"></i></h2>
                  </div>
                  <div id="cfilter" class="filter-body">
                     <ul x-data="{url: 'https://directory.smarteyeapps.com' }">
                        @foreach($categories as $category)  

                            <li class="cp">
                            <a href="{{ route('categories.show', $category->slug) }}">
                            <input  checked  @click="catFilterClick(url, 'restuarent123', 0, 'list', '')" class="form-check-input" type="radio" name="filtercat" id="filtercat"> {{ $category->name }}
                            </a> 
                            </li>
                        @endforeach

                     </ul>
                  </div>
                  <div  x-data="{clocation}" class="filter-head border-top border-bottom">
                     <h2>تصفية حسب التقييمات<i @click="filterRating()" class="bi cp float-end bi-funnel"></i></h2>
                  </div>
                  <div id="clocation" x-data="{url: 'https://directory.smarteyeapps.com/cat/restuarent123' }" class="filter-body">
                     <ul class="rev">
                        <li>
                           <input checked  @click="ratingFilterClick(url, 0, 'list', '')" class="form-check-input" type="radio" name="rating" id="rating">
                           جميع التقييمات
                        </li>
                        <li><input ; @click="ratingFilterClick(url, 5, 'list', '')" class="form-check-input" type="radio" name="rating" id="rating">
                           <i class="bi act bi-star-fill"></i>
                           <i class="bi act bi-star-fill"></i>
                           <i class="bi act bi-star-fill"></i>
                           <i class="bi act bi-star-fill"></i>
                           <i class="bi act bi-star-fill"></i>
                        </li>
                        <li>
                           <input ; @click="ratingFilterClick(url, 4, 'list', '')" class="form-check-input" type="radio" name="rating" id="rating">
                           <i class="bi act bi-star-fill"></i>
                           <i class="bi act bi-star-fill"></i>
                           <i class="bi act bi-star-fill"></i>
                           <i class="bi act bi-star-fill"></i>
                           <i class="bi  bi-star-fill"></i>
                        </li>
                        <li>
                           <input ; @click="ratingFilterClick(url, 3, 'list', '')" class="form-check-input" type="radio" name="rating" id="rating">
                           <i class="bi act bi-star-fill"></i>
                           <i class="bi act bi-star-fill"></i>
                           <i class="bi act bi-star-fill"></i>
                           <i class="bi  bi-star-fill"></i>
                           <i class="bi  bi-star-fill"></i>
                        </li>
                        <li>
                           <input ; @click="ratingFilterClick(url, 2, 'list', '')" class="form-check-input" type="radio" name="rating" id="rating">
                           <i class="bi act bi-star-fill"></i>
                           <i class="bi act bi-star-fill"></i>
                           <i class="bi  bi-star-fill"></i>
                           <i class="bi  bi-star-fill"></i>
                           <i class="bi  bi-star-fill"></i>
                        </li>
                        <li>
                           <input ; @click="ratingFilterClick(url, 1, 'list', '')" class="form-check-input" type="radio" name="rating" id="rating">
                           <i class="bi act bi-star-fill"></i>
                           <i class="bi  bi-star-fill"></i>
                           <i class="bi  bi-star-fill"></i>
                           <i class="bi  bi-star-fill"></i>
                           <i class="bi  bi-star-fill"></i>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-9 col-md-8">
            <div class="sort-control mb-4 row">
               <div class="col-6">
                  <p class="pt-2">عرض <b> 1 - 
                     3
                     من  3 نتائج</b>
                  </p>
               </div>
               <div class="col-6">
                  <ul>
                     <a href="restuarent12343ce.html?rating=0&amp;typ=list&amp;key=">
                        <li  class="border-primary" ><i class="bi text-primary bi-list-ul"></i></li>
                     </a>
                     <a href="restuarent123d7fb.html?rating=0&amp;typ=grid&amp;key=">
                        <li  class="ms-2"><i class="bi bi-grid"></i></li>
                     </a>
                  </ul>
               </div>
            </div>
            @foreach($businesses as $business)  
                <div class="row shadow-sm list-row border rounded">
                <div class="col-lg-4  pe-0 img-col">
                    <a href="{{ url('business/' . $business->slug) }}">
                    <img  class="rounded" src="{{ asset('storage/' . $business->image) }}" alt="{{ $business->name }}">
                    </a>
                </div>
                <div class="col-lg-8 detail-col">
                    <a href="{{ url('business/' . $business->slug) }}">
                        <div class="bofy-col">
                            <h2 class="text-truncate">{{ $business->name }} 
                            </i>
                            </h2>
                            <p class="text-truncate">{{ $business->description }}</p>
                            <ul class="row ms-1">
                            <li class="col-md-4"><i class="bi bi-telephone"></i> {{ $business->phone }}</li>
                            <li class="col-md-8"><i class="bi bi-envelope"></i> {{ $business->email }}</li>
                            </ul>
                            <ul class="row ms-1">
                            <li class="col-md-4"> <i class="bi bi-map"></i> {{ $business->country ?? '' }}</li>
                            <li class="col-md-8">
                                <p class="text-truncate"><i class="bi bi-geo-alt"></i>{{ $business->address }}</p>
                            </li>
                            </ul>
                        </div>
                    </a>
                    <div  class="footcover">
                        <ul>
                            <li class="rev">
                            <i class="bi  act  bi-star-fill"></i>
                            <i class="bi  act  bi-star-fill"></i>
                            <i class="bi  act  bi-star-fill"></i>
                            <i class="bi  act  bi-star-fill"></i>
                            <i class="bi  act  bi-star-fill"></i>
                            <small>{{ $business->rating ?? '0.0' }} ({{ $business->reviews_count ?? 0 }} Reviews)</small>
                            </li>
                            <li class="">
                            <div class="save">
                                <a data-bs-toggle="modal" data-bs-target="#loginAlert"><i class="bi bi-heart"></i></a>
                            </div>
                            </li>
                        </ul>
                    </div>
                </div>
                </div>
            @endforeach

            <div class="pagination listng-pagination row ">
               <nav>
               </nav>
            </div>
         </div>
      </div>
   </div>
</div>
{{-- End Second section --}}
@endsection