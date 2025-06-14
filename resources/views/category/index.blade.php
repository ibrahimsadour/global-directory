@extends('layouts.app')
@section('title',setting('site_title').' - كل الفئات')
@section('seo_keyword',setting('seo_meta_keywords'))
@section('seo_description',setting('seo_meta_description'))
@section('og:image', asset('storage/site-settings/default-banner.webp'))

@section('content')

{{-- breadcrumb --}}
<x-breadcrumb :items="[
    ['title' => 'الرئيسية', 'url' => url('/')],
    ['title' => 'كل الفئات', 'url' => route('categories.index')],
]" />
<style>
    .dropdown-category {
        position: relative;
        display: inline-block;
    }

    .dropdown-category > a {
        display: block;
        padding: 10px 15px;
        font-weight: 700;
        color: #333;
        text-decoration: none;
        background-color: #f8f8f8;
        border-radius: 6px;
    }

    .dropdown-category > a:hover {
        background-color: #e0e0e0;
    }

    .dropdown-submenu {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background-color: #fff;
        min-width: 220px;
        padding: 10px 0;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        border-radius: 6px;
        z-index: 999;
    }

    .dropdown-submenu a {
        display: block;
        padding: 8px 15px;
        text-decoration: none;
        color: #333;
        white-space: nowrap;
    }

    .dropdown-submenu a:hover {
        background-color: #f1f1f1;
    }

    .dropdown-category:hover .dropdown-submenu {
        display: block;
    }
</style>
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
                  <ul>
                     @foreach($categories as $category)
                        @if(is_null($category->parent_id)) {{-- الفئات الرئيسية فقط --}}
                              <li class="cp fw-bold">
                                 @if($category->children && $category->children->count())
                                    {{-- زر توسيع مع رمز ⯈ --}}
                                    <span onclick="toggleSubcategories(this)" style="cursor: pointer; font-weight: 700;">
                                          <span class="toggle-icon" style=" color: #0062ff; ">⯈</span> {{ $category->name }} <span style=" color: #0062ff; ">( {{$category->children->count()}} )</span>
                                    </span>

                                    {{-- قائمة الفئات الفرعية --}}
                                    <ul class="ms-4 d-none">
                                          @foreach($category->children as $child)
                                             <li class="cp">
                                                <a href="{{ route('categories.show', $child->slug) }}" style="margin-right: 10px;">
                                                      - {{ $child->name }}
                                                </a>
                                             </li>
                                          @endforeach
                                    </ul>
                                 @else
                                    {{-- لا يوجد فروع – فقط الاسم كرابط --}}
                                    <a href="{{ route('categories.show', $category->slug) }}" style="font-weight: 700;">
                                          {{ $category->name }}
                                    </a>
                                 @endif
                              </li>
                        @endif
                     @endforeach
                  </ul>

                  {{-- JavaScript للتبديل بين إظهار/إخفاء القوائم الفرعية --}}
                  <script>
                     function toggleSubcategories(element) {
                        const icon = element.querySelector('.toggle-icon');
                        const sublist = element.nextElementSibling;

                        if (sublist) {
                              sublist.classList.toggle('d-none');
                              // تبديل الرمز ⯈ و ⯆
                              if (icon.textContent === '⯈') {
                                 icon.textContent = '⯆';
                              } else {
                                 icon.textContent = '⯈';
                              }
                        }
                     }
                  </script>

                  {{-- CSS لإخفاء العناصر بشكل مبدئي --}}
                  <style>
                     .d-none {
                        display: none;
                     }
                  </style>


                  </div>

                  <div  x-data="{clocation}" class="filter-head border-top border-bottom">
                     <h2>تصفية حسب التقييمات<i @click="filterRating()" class="bi cp float-end bi-funnel"></i></h2>
                  </div>
                  <div id="clocation" x-data="#" class="filter-body">
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