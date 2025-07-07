@extends('layouts.app')

@if(isset($category))
    @section('title',$category->seo->meta_title)
    @section('seo_keyword',$category->seo->meta_keywords)
    @section('seo_description',$category->seo->meta_description)
    @section('og:image', asset('storage/' . $category->image))
@endif
@section('structured_data')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CollectionPage",
  "name": "{{ $category->name }} | {{ setting('site_title', 'Global Directory') }}",
  "description": "{{ $category->description ?? 'اكتشف جميع الأنشطة والخدمات ضمن تصنيف ' . $category->name }}",
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
        "name": "{{ $category->name }}",
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
                           @foreach($categories as $category)
                              @if(is_null($category->parent_id) && $category->is_active)
                                 @php
                                    $activeChildren = $category->children->where('is_active', 1);
                                    $isActiveMain = request()->is('categories/'.$category->slug);
                                    $hasActiveChild = $activeChildren->contains(function ($child) {
                                       return request()->is('categories/'.$child->slug);
                                    });
                                    $shouldOpen = $isActiveMain || $hasActiveChild;
                                 @endphp

                                 <li class="cp">
                                    @if($activeChildren->count())
                                       <span 
                                          onclick="toggleSubcategories(this)" 
                                          style="cursor: pointer; {{ $isActiveMain ? 'font-weight: bold;' : '' }}"
                                          class="{{ $isActiveMain ? 'active-category' : '' }}"
                                       >
                                          <span class="toggle-icon" style="color: #0062ff;">
                                             {{ $shouldOpen ? '⯆' : '⯈' }}
                                          </span> 
                                          {{ $category->name }}
                                          <span style="color: #0062ff;">({{ $activeChildren->count() }})</span>
                                       </span>

                                       <ul class="ms-4 {{ $shouldOpen ? '' : 'd-none' }}">
                                          @foreach($activeChildren as $child)
                                             <li class="cp">
                                                <a 
                                                   href="{{ route('categories.show', $child->slug) }}" 
                                                   style="margin-right: 10px; {{ request()->is('categories/'.$child->slug) ? 'font-weight: bold;' : '' }}"
                                                   class="{{ request()->is('categories/'.$child->slug) ? 'active-category' : '' }}"
                                                >
                                                   - {{ $child->name }}
                                                </a>
                                             </li>
                                          @endforeach
                                       </ul>
                                    @else
                                       <a 
                                          href="{{ route('categories.show', $category->slug) }}" 
                                          style="{{ $isActiveMain ? 'font-weight: bold;' : '' }}" 
                                          class="{{ $isActiveMain ? 'active-category' : '' }}"
                                       >
                                          {{ $category->name }}
                                       </a>
                                    @endif
                                 </li>
                              @endif
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

                  @php
                        $image = $business->image;

                        if (empty($image)) {
                           $imageUrl = asset('storage/business_photos/default.webp'); // صورة افتراضية
                        } elseif (Str::startsWith($image, 'http')) {
                           $imageUrl = $image; // رابط خارجي مباشر
                        } elseif (Str::contains($image, '/')) {
                           $imageUrl = asset('storage/' . $image); // صورة من السيرفر
                        } else {
                           $imageUrl = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photo_reference=' 
                              . $image . '&key=' . config('services.google.maps_api_key');
                        }
                  @endphp
                  <div class="col-lg-4  pe-0 img-col">
                     <a href="{{ url('business/' . $business->slug) }}" alt="{{ $business->name }}">
                        <img 
                           src="{{ $imageUrl }}" 
                           alt="{{ $business->name }}" 
                           title="{{ $business->name }}" 
                           loading="lazy"
                           class="rounded"
                           style="height=;height: 200px;width: 100%;"
                        >
                     </a>
                  </div>

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
            {{ $businesses->withQueryString()->links('vendor.pagination.custom-bootstrap') }}
         </div>
      </div>
   </div>
</div>
{{-- End Second section --}}
@endsection