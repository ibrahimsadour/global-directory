@extends('layouts.app')
@section('title',$location->seo->meta_title ?? setting('seo_meta_title') .'|'.$location->area )
@section('seo_keyword',$location->seo->meta_keywords ?? setting('seo_meta_keywords') .'|'.$location->area )
@section('seo_description',$location->seo->meta_description ?? setting('seo_meta_description') .'|'.$location->area )
@section('og:image', asset('storage/' . $location->image) ?? asset('storage/site-settings/default-banner.webp'))
@section('structured_data')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "دليل الأنشطة في {{ $location->name }} | {{ setting('site_title', 'Global Directory') }}",
  "description": "استعرض جميع الأنشطة التجارية والخدمية في محافظة {{ $location->name }}.",
  "url": "{{ url()->current() }}",
  "breadcrumb": {
    "@type": "BreadcrumbList",
    "itemListElement": [
      {
        "@type": "ListItem",
        "position": 1,
        "name": "الرئيسية",
        "item": "{{ url('/') }}"
      },
      {
        "@type": "ListItem",
        "position": 2,
        "name": "{{ $location->name }}",
        "item": "{{ url()->current() }}"
      }
    ]
  }
}
</script>
@endsection

@section('content')

{{-- breadcrumb --}}
<x-breadcrumb :items="[
    ['title' => 'الرئيسية', 'url' => url('/')],
    ['title' => 'كل المحافظات', 'url' => route('governorates.index')],
    ['title' => $location->name]
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
                  <style>
                     .active-category {
                        color: #0062ff !important;
                        font-weight: bold;
                     }
                  </style>

                  <script>
                     function toggleSubcategories(element) {
                        const icon = element.querySelector('.toggle-icon');
                        const sublist = element.nextElementSibling;

                        if (sublist) {
                           sublist.classList.toggle('d-none');
                           icon.textContent = (icon.textContent === '⯈') ? '⯆' : '⯈';
                        }
                     }
                  </script>

                  <div id="cfilter" class="filter-body">
                     <ul>
@foreach($governorates as $governorate)
   @php
      $locations = $governorate->locations;
      $isActiveGovernorate = request()->is('governorates/'.$governorate->slug);
      $hasActiveLocation = $locations->contains(fn ($loc) => request()->is('locations/'.$loc->slug));
      $shouldOpen = $isActiveGovernorate || $hasActiveLocation;
   @endphp

   <li class="cp">
      @if($locations->count())
         <span 
            onclick="toggleSubcategories(this)" 
            style="cursor: pointer; {{ $isActiveGovernorate ? 'font-weight: bold;' : '' }}"
            class="{{ $isActiveGovernorate ? 'active-category' : '' }}"
         >
            <span class="toggle-icon" style="color: #0062ff;">
               {{ $shouldOpen ? '⯆' : '⯈' }}
            </span> 
            {{ $governorate->name }}
            <span style="color: #0062ff;">({{ $locations->count() }})</span>
         </span>

         <ul class="ms-4 {{ $shouldOpen ? '' : 'd-none' }}">
            @foreach($locations as $location)
               <li class="cp">
                  <a 
                     href="{{ route('locations.show', $location->slug) }}" 
                     style="margin-right: 10px; {{ request()->is('locations/'.$location->slug) ? 'font-weight: bold;' : '' }}"
                     class="{{ request()->is('locations/'.$location->slug) ? 'active-category' : '' }}"
                  >
                     - {{ $location->area }}
                  </a>
               </li>
            @endforeach
         </ul>
      @else
         <a 
            href="{{ route('governorates.show', $governorate->slug) }}" 
            style="{{ $isActiveGovernorate ? 'font-weight: bold;' : '' }}" 
            class="{{ $isActiveGovernorate ? 'active-category' : '' }}"
         >
            {{ $governorate->name }}
         </a>
      @endif
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
                     <a href="">
                        <li  class="border-primary" ><i class="bi text-primary bi-list-ul"></i></li>
                     </a>
                     <a href="">
                        <li  class="ms-2"><i class="bi bi-grid"></i></li>
                     </a>
                  </ul>
               </div>
            </div>
            @foreach($businesses as $business)  
                <div class="row shadow-sm list-row border rounded">
                  @if($business->image)
                     <div class="col-lg-4  pe-0 img-col">
                        <a href="{{ url('business/' . $business->slug) }}">
                           <img  class="rounded" src="{{ asset('storage/' . $business->image) }}"  title="{{ $business->name ?? '-' }}" alt="{{ $business->name ?? '-' }}" />
                        </a>
                     </div>
                  @endif
                <div class="col-lg-8 detail-col">
                    <a href="{{ url('business/' . $business->slug) }}">
                        <div class="bofy-col">
                           @if(!empty($business->name))
                              <h2 class="text-truncate">{{ $business->name }} 
                           @endif
                            </i>
                            </h2>
                            @if(!empty($business->description))
                            <p class="text-truncate">{{ $business->description }}</p>
                            @endif
                           <ul class="row ms-1">
                              @if(!empty($business->phone))
                              <li class="col-md-4"><i class="bi bi-telephone"></i> {{ $business->phone }}</li>
                              @endif
                              @if(!empty($business->email))
                              <li class="col-md-8"><i class="bi bi-envelope"></i> {{ $business->email }}</li>
                              @endif
                              </ul>
                              <ul class="row ms-1">
                              @if(!empty($business->governorate->name))
                              <li class="col-md-4"> <i class="bi bi-map"></i> {{ $business->governorate->name ?? '' }}</li>
                              @endif
                              @if(!empty($business->address))
                              <li class="col-md-8">
                                 <p class="text-truncate"><i class="bi bi-geo-alt"></i>{{ $business->address }}</p>
                              </li>
                              @endif
                            </ul>
                        </div>
                    </a>
                    <div  class="footcover">
                        <ul>
                            <li class="rev">
                            <i class="bi  bi-star-fill"></i>
                            <i class="bi  bi-star-fill"></i>
                            <i class="bi  bi-star-fill"></i>
                            <i class="bi  bi-star-fill"></i>
                            <i class="bi  bi-star-fill"></i>
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