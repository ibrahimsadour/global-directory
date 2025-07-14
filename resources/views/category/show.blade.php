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
         <div class="col-lg-9 col-md-8">
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