@extends('layouts.app')

@if(isset($business))
   @section('title', $seo_title)
   @section('seo_description', $seo_description)
   @section('seo_keyword', $seo_keywords)
   @section('og:image', $seo_image)
@endif

@section('structured_data')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "{{ $business->name }}",
  "description": "{{ $seo_description }}",
  "url": "{{ url()->current() }}",
  "image": "{{ $business->image ? asset('storage/' . $business->image) : asset('storage/site-settings/default-banner.webp') }}",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "{{ $business->governorate->name ?? '' }}",
    "addressRegion": "{{ $business->location->area ?? '' }}",
    "addressCountry": "KW"
  },
  "telephone": "{{ $business->phone }}",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.9",
    "reviewCount": "257"
  }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
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
      "name": "{{ $business->governorate->name ?? 'غير محددة' }}",
      "item": "{{ route('governorates.show', $business->governorate->slug ?? '') }}"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "{{ $business->category->name ?? 'غير محددة' }}",
      "item": "{{ route('categories.show', $business->category->slug ?? '') }}"
    },
    {
      "@type": "ListItem",
      "position": 4,
      "name": "{{ $business->name }}",
      "item": "{{ url()->current() }}"
    }
  ]
}
</script>
@endsection


@section('content')

{{-- breadcrumb --}}
<x-breadcrumb :items="[
    ['title' => 'الرئيسية', 'url' => url('/')],
   //  ['title' => 'كل الفئات', 'url' => url('/cat')],
    ['title' => $business->name]
]" />


{{-- Begin Second section --}}
<div class="container-fluid single-container" bis_skin_checked="1">
   <div class="container" bis_skin_checked="1">
      <div class="row" bis_skin_checked="1">
         <div class="col-md-8" bis_skin_checked="1">
            <div class="businesscover shadow-sm " bis_skin_checked="1">
               <div class="imagecover text-center p-2" bis_skin_checked="1">
                  @if(!empty($business->image))
                     <img src="{{ asset('storage/' . $business->image) }}" alt="{{ $business->name }}">
                  @endif
               </div>
               <div class="business-info" bis_skin_checked="1">

                  @if(!empty($business->name))
                     <h1>{{ $business->name }}</h1>
                  @endif

                  @if(!empty($business->description))
                     <p>{{ $business->description }}</p>
                  @endif

               </div>
               <div class="more-info row" bis_skin_checked="1">
                  <div class="col-lg-5 col-md-12" bis_skin_checked="1">
                     <ul>

                        @if(!empty($business->phone))
                           <li>
                              <a href="tel:{{ $business->phone }}">
                                    <i class="bi bi-telephone"></i> {{ $business->phone }}
                              </a>
                           </li>
                        @endif

                        @if(!empty($business->email))
                           <li>
                              <a href="mailto:{{ $business->email }}">
                                    <i class="bi bi-envelope"></i> {{ $business->email }}
                              </a>
                           </li>
                        @endif

                        @if(!empty($business->website))
                           @php
                              // احصل على الدومين فقط بدون www وأي مسار بعد النطاق
                              $host = parse_url($business->website, PHP_URL_HOST);

                              // إزالة www. من البداية إذا موجود
                              $host = preg_replace('/^www\./', '', $host);
                              @endphp
                              @if(!empty($business->website))
                              <li>
                                 <a href="{{ $business->website }}" target="_blank" rel="nofollow">
                                       <i class="bi bi-globe"></i> {{ $host }}
                                 </a>
                              </li>
                              @endif
                        @endif

                     </ul>
                  </div>
                  <div class="col-lg-7 col-md-12" bis_skin_checked="1">
                     <ul>
                        @if(!setting('site_address'))
                           <li> <i class="bi bi-map"></i>{{setting('site_address')}} </li>
                        @endif
                        @if(!empty($business->address))
                           <li class="text-truncate"><i class="bi bi-geo-alt"></i> {{ $business->address ? $business->address : '' }}</li>
                        @endif
                        @if(!empty($business->whatsapp))
                           @php
                              // إزالة أي مسافات أو رموز زائدة من الرقم
                              $whatsapp = preg_replace('/\D/', '', $business->whatsapp);
                           @endphp
                           <li>
                              <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="nofollow">
                                    <i class="bi bi-whatsapp"></i> {{ $business->whatsapp }}
                              </a>
                           </li>
                        @endif                     
                     </ul>
                  </div>
               </div>
               <div class="footcover" bis_skin_checked="1">
                  <ul>
                     <li class="rev">
                        <i class="bi  act  bi-star-fill"></i>
                        <i class="bi  act  bi-star-fill"></i>
                        <i class="bi  act  bi-star-fill"></i>
                        <i class="bi  act  bi-star-fill"></i>
                        <i class="bi  bi-star-fill"></i>
                        <small>4.0  (2 Reviews)</small>
                     </li>
                     <li class="">
                        <div class="save" bis_skin_checked="1">
                           <a data-bs-toggle="modal" data-bs-target="#loginAlert"><i class="bi bi-heart"></i></a>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
            {{-- <div class="overview shadow-sm no-margin row" bis_skin_checked="1">
               <div class="details p-3 border-bottom" bis_skin_checked="1">
                  <p class="mb-2">{{ $business->description }}</p>
               </div>
            </div> --}}
            
            {{-- الخدمات والمنتجات --}}
            {{-- <div x-data="dropdown, {service:[], bid: 2 }" class="overview services shadow-sm no-margin " bis_skin_checked="1">
               <h2 class="border-bottom">Our Services</h2>
               <div class="servrow row no-margin" bis_skin_checked="1">
                  <div class="col-md-4 servcov" bis_skin_checked="1">
                     <h6 class="text-truncate"><i class="bi bi-arrow-right-short"></i> Cataract Surgery</h6>
                  </div>
                  <div class="col-md-4 servcov" bis_skin_checked="1">
                     <h6 class="text-truncate"><i class="bi bi-arrow-right-short"></i> Paediatric Ophthalmology</h6>
                  </div>
                  <div class="col-md-4 servcov" bis_skin_checked="1">
                     <h6 class="text-truncate"><i class="bi bi-arrow-right-short"></i> Emergency Eye Care</h6>
                  </div>
                  <div class="col-md-4 servcov" bis_skin_checked="1">
                     <h6 class="text-truncate"><i class="bi bi-arrow-right-short"></i> Neuro Opthalmology</h6>
                  </div>
                  <div class="col-md-4 servcov" bis_skin_checked="1">
                     <h6 class="text-truncate"><i class="bi bi-arrow-right-short"></i> Neuro Ophthalmology</h6>
                  </div>
                  <div class="col-md-4 servcov" bis_skin_checked="1">
                     <h6 class="text-truncate"><i class="bi bi-arrow-right-short"></i> Computer Vision Syndrome</h6>
                  </div>
                  <template x-for="s in services">
                     <div class="col-md-4 servcov">
                        <h6 class="text-truncate"><i class="bi bi-arrow-right-short"></i> <span x-text="s.name"></span></h6>
                     </div>
                  </template>
               </div>
               <div class="div m-1 pb-1" bis_skin_checked="1">
                  <button x-show="showMore" @click="loadMoreServices" id="rivmore" type="button" class="btn morefont w-100 btn-outline-primary">Show More Services</button>
               </div>
            </div> --}}
            {{-- <div x-data="products" class="overview products shadow-sm no-margin " bis_skin_checked="1">
               <h2 class="border-bottom">Our Products</h2>
               <div class="servrow row no-margin" bis_skin_checked="1">
                  <div class="col-lg-4 col-md-6 productcol" bis_skin_checked="1">
                     <div class="row no-margin" bis_skin_checked="1">
                        <div class="col-4 pimg" bis_skin_checked="1">
                           <img src="/storage/product/1pvcZPdRflJAPgq1HeIF3wOHq9hZgkvUJjQFweOP.jpg" alt="">
                        </div>
                        <div class="col-8 pdet" bis_skin_checked="1">
                           <h6 class="text-truncate">Meny Special Eye Glass</h6>
                           <b>₹120</b>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 productcol" bis_skin_checked="1">
                     <div class="row no-margin" bis_skin_checked="1">
                        <div class="col-4 pimg" bis_skin_checked="1">
                           <img src="/storage/product/2uag0h7HcjwePwSnjuHCcuj2IVZDPBq5f7Rd6nD5.jpg" alt="">
                        </div>
                        <div class="col-8 pdet" bis_skin_checked="1">
                           <h6 class="text-truncate">Kiss Cool Sun Glass</h6>
                           <b>₹140</b>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 productcol" bis_skin_checked="1">
                     <div class="row no-margin" bis_skin_checked="1">
                        <div class="col-4 pimg" bis_skin_checked="1">
                           <img src="/storage/product/kSi7MOV0qo7SdVMJdYyN2SWcucVYjzvHeMfGFGBW.jpg" alt="">
                        </div>
                        <div class="col-8 pdet" bis_skin_checked="1">
                           <h6 class="text-truncate">Super Cool Eye Glass Colord</h6>
                           <b>₹150</b>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 productcol" bis_skin_checked="1">
                     <div class="row no-margin" bis_skin_checked="1">
                        <div class="col-4 pimg" bis_skin_checked="1">
                           <img src="/storage/product/BJsjsiCHXGAo4cqxDHgAf422PbnKJspSX8LT7y7f.jpg" alt="">
                        </div>
                        <div class="col-8 pdet" bis_skin_checked="1">
                           <h6 class="text-truncate">Rigmu Cool Kids Eye Glass</h6>
                           <b>₹189</b>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 productcol" bis_skin_checked="1">
                     <div class="row no-margin" bis_skin_checked="1">
                        <div class="col-4 pimg" bis_skin_checked="1">
                           <img src="/storage/product/iK0ipuaWcnw02sI3bzxwf5e2Sm74GTtvEFejoQXC.jpg" alt="">
                        </div>
                        <div class="col-8 pdet" bis_skin_checked="1">
                           <h6 class="text-truncate">Super Cool Mens Eye Glass</h6>
                           <b>₹133</b>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 productcol" bis_skin_checked="1">
                     <div class="row no-margin" bis_skin_checked="1">
                        <div class="col-4 pimg" bis_skin_checked="1">
                           <img src="/storage/product/70Aj31ykRHnev7D8CMnUETcWSR6cX0lFhxy1zUxk.jpg" alt="">
                        </div>
                        <div class="col-8 pdet" bis_skin_checked="1">
                           <h6 class="text-truncate">Kids Rimson Eye Glass</h6>
                           <b>₹144</b>
                        </div>
                     </div>
                  </div>
                  <template x-for="p in products">
                     <div class="col-lg-4 col-md-6 productcol">
                        <div class="row no-margin">
                           <div class="col-4 pimg">
                              <img :src="p.image" alt="">
                           </div>
                           <div class="col-8 pdet">
                              <h6 class="text-truncate" x-text="p.name"></h6>
                              <b>₹ <span x-text="p.price"></span></b>
                           </div>
                        </div>
                     </div>
                  </template>
               </div>
               <button x-show="showMore" @click="loadMoreProducts" id="rivmore" type="button" class="btn morefont w-100 mt-2 btn-outline-primary">Show More Products</button>
            </div> --}}

            {{-- معرض الصوور --}}
            @php
               $gallery = [];
               if($business->gallery) {
                  $gallery = is_array($business->gallery) ? $business->gallery : json_decode($business->gallery, true);
               }
            @endphp

            @if($gallery && count($gallery))
               <div class="overview products shadow-sm no-margin">
                  <h2 class="border-bottom">معرض الصور</h2>
                  <div class="row no-margin">
                        @foreach($gallery as $img)
                           <div class="col-md-3 col-sm-4 col-6 mb-3 p-2">
                              <a href="{{ asset('storage/' . $img) }}" target="_blank">
                                    <img 
                                       src="{{ asset('storage/' . $img) }}" 
                                       alt="صورة من المعرض"
                                       style="width: 100%; height: 160px; object-fit: cover; border-radius: 10px; border: 1px solid #eee;"
                                    >
                              </a>
                           </div>
                        @endforeach
                  </div>
               </div>
            @endif



            {{-- التعليقات --}}
            {{-- <section x-data="review">
               <div id="revbox" class="review-box overview shadow-sm " bis_skin_checked="1">
                  <h2 class="border-bottom">Reviews</h2>
                  <div x-show="reviews.lengt &lt; 1" bis_skin_checked="1" style="display: none;">
                     <div class="row reviewrow" bis_skin_checked="1">
                        <div class="col-md-2 col-3 " bis_skin_checked="1">
                           <img class="rounded-circle border border-1 p-2" src="/storage/user/resize/iqeL3q4MenO9lPmVkWFIEm5uDaSTUA8GepztH7jn.jpg" alt="">
                        </div>
                        <div class="col-md-10 align-items-center col-9 rcolm" bis_skin_checked="1">
                           <div class="review" bis_skin_checked="1">
                              <i class="bi  act  act bi-star-fill"></i>
                              <i class="bi  act  bi-star-fill"></i>
                              <i class="bi  act  bi-star-fill"></i>
                              <i class="bi  bi-star-fill"></i>
                              <i class="bi   bi-star-fill"></i>
                           </div>
                           <h3>Reena Samuel</h3>
                           <small> 09 Jun 2025 </small>
                           <div class="review-text" bis_skin_checked="1">
                              Cras ut tortor imperdiet, egestas ligula ac, dapibus augue. Proin auctor congue arcu 
                           </div>
                        </div>
                     </div>
                     <div class="row reviewrow" bis_skin_checked="1">
                        <div class="col-md-2 col-3 " bis_skin_checked="1">
                           <img class="rounded-circle border border-1 p-2" src="/storage/user/resize/default.png" alt="">
                        </div>
                        <div class="col-md-10 align-items-center col-9 rcolm" bis_skin_checked="1">
                           <div class="review" bis_skin_checked="1">
                              <i class="bi  act  act bi-star-fill"></i>
                              <i class="bi  act  bi-star-fill"></i>
                              <i class="bi  act  bi-star-fill"></i>
                              <i class="bi  act  bi-star-fill"></i>
                              <i class="bi  act   bi-star-fill"></i>
                           </div>
                           <h3>John Smith</h3>
                           <small> 09 Jun 2025 </small>
                           <div class="review-text" bis_skin_checked="1">
                              laoreet ac aliquet in, imperdiet ut mauris. Maecenas nec varius velit, auctor volutpat eros 
                           </div>
                        </div>
                     </div>
                  </div>
                  <template x-for="(r, i) in reviews">
                     <div class="row reviewrow">
                        <div class="col-md-2 col-3 center">
                           <img class="rounded-circle border border-1 p-2" :src="r.user.resize" alt="">
                        </div>
                        <div class="col-md-10 col-9 align-content-center rcolm">
                           <div class="review">
                              <i class="bi bi-star-fill" :class="{ 'act': r.rating &gt;= 1 }"></i>
                              <i class="bi bi-star-fill" :class="{ 'act': r.rating &gt;= 2 }"></i>
                              <i class="bi bi-star-fill" :class="{ 'act': r.rating &gt;= 3 }"></i>
                              <i class="bi bi-star-fill" :class="{ 'act': r.rating &gt;= 4 }"></i>
                              <i class="bi bi-star-fill" :class="{ 'act': r.rating &gt;= 5 }"></i>
                           </div>
                           <h3 x-text="r.user.name"></h3>
                           <small x-text="r.dat">  </small>
                           <div class="review-text">
                              <span x-show="edit != i" x-text="r.message"></span>
                              <textarea x-show="edit == i" name="" x-model="r.message" class="form-control" id="" cols="30" rows="3"></textarea>
                              <ul x-show="r.user.id == 0" class="actionreview">
                                 <a data-bs-toggle="modal" data-bs-target="#removeRat" @click="removeRating(i)">
                                    <li><i class="bi bi-trash"></i> Delete</li>
                                 </a>
                                 <li x-show="edit != i" @click="editReview(i)"><i class="bi bi-pencil-square"></i> Edit</li>
                                 <li x-show="edit == i" @click="updateReview(i)"><i class="bi bi-check2-square"></i> Save</li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </template>
               </div>
               <div class="add-review overview shadow-sm" bis_skin_checked="1">
                  <h2 class="border-bottom">Add Review</h2>
                  <div x-show="success" class="succmsg p-3 pb-0" bis_skin_checked="1" style="display: none;">
                     <div class="alert alert-success mb-0" role="alert" bis_skin_checked="1">
                        Review Posted Sucessfully
                     </div>
                  </div>
                  <div class="row p-3" bis_skin_checked="1">
                     <div class="col-md-12 add-reviwcol" bis_skin_checked="1">
                        <li class="rev mb-3"> 
                           <label>Select Rating <span>:</span> </label>
                           <i @click="addStar(1)" class="bi bi-star-fill act" :class="{ 'act': star &gt;= 1 }"></i>
                           <i @click="addStar(2)" class="bi bi-star-fill act" :class="{ 'act': star &gt;= 2 }"></i>
                           <i @click="addStar(3)" class="bi bi-star-fill act" :class="{ 'act': star &gt;= 3 }"></i>
                           <i @click="addStar(4)" class="bi bi-star-fill" :class="{ 'act': star &gt;= 4 }"></i>
                           <i @click="addStar(5)" class="bi bi-star-fill" :class="{ 'act': star &gt;= 5 }"></i>
                        </li>
                        <form @submit.prevent="postReview" action="">
                           <div class="col-md-12" bis_skin_checked="1">
                              <textarea x-model="message" :class="{ 'inerror':  error.message !== undefined }" placeholder="Enter Your Message" class="form-control mb-1" name="" id="" cols="30" rows="5"></textarea>
                              <div x-show="error.message != undefined" class="smart-valid" x-text="error.message" bis_skin_checked="1" style="display: none;"></div>
                           </div>
                           <div class="col-md-12 mt-3 text-end" bis_skin_checked="1">
                              <a data-bs-toggle="modal" data-bs-target="#loginAlert" href="#">
                              <button class="btn btn-primary">Submit Your Review</button>
                              </a>
                           </div>
                        </form>
                     </div>
                  </div>
                  <!-- Modal -->
                  <div class="modal fade" id="removeRat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" bis_skin_checked="1">
                     <div class="modal-dialog" bis_skin_checked="1">
                        <div class="modal-content" bis_skin_checked="1">
                           <div class="modal-header" bis_skin_checked="1">
                              <h5 class="modal-title" id="exampleModalLabel">Are you sure Want to Delete ?</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <div class="modal-footer" bis_skin_checked="1">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button @click="confirmRemove" type="button" class="btn btn-danger" data-bs-dismiss="modal">Yes Delete</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section> --}}
         </div>
         <div class="col-md-4 sidecl" bis_skin_checked="1">

            {{-- الخريطة --}}
            <script>
               document.addEventListener('DOMContentLoaded', function () {
                  const latitude = @json($business->latitude ?? 29.3759);
                  const longitude = @json($business->longitude ?? 47.9774);
                  const address = @json($business->address ?? '');

                  if (!isNaN(latitude) && !isNaN(longitude)) {
                     const map = L.map('map').setView([latitude, longitude], 14);

                     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                     }).addTo(map);

                     const marker = L.marker([latitude, longitude]).addTo(map);

                     if (address) {
                        marker.bindPopup(address).openPopup();
                     }

                     L.control.scale().addTo(map);
                  }
               });
            </script>

            <div class=" shadow-sm overview mt-4" bis_skin_checked="1">
               <h2 class="border-bottom">العنوان على الخريطة</h2>
               <div id="map" style="width: 100%; height: 350px; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"></div>
            </div>
            
            {{-- صاحب النشاط --}}
            <div class="bycard shadow-sm overview mb-4" bis_skin_checked="1">
               <h2 class="border-bottom">تم نشره بواسطة</h2>
               <div class="usercover" bis_skin_checked="1">

                  @if($business->user?->profile_photo)
                     <img 
                        src="{{ asset('storage/' . $business->user->profile_photo) }}" 
                        alt="{{ $business->user?->name ?? 'غير معروف' }}" 
                        style="width: 64px; height: 64px; object-fit: cover; border-radius: 50%; border: 2px solid #eee;"
                     >
                  @else
                     <img 
                        src="{{ asset('images/default-profile.png') }}" 
                        alt="صورة افتراضية"
                        style="width: 64px; height: 64px; object-fit: cover; border-radius: 50%; border: 2px solid #eee;"
                     >
                  @endif


                  <h4>
                     {{ $business->user?->name ?? 'غير معروف' }}
                     
                        @if($business->user?->is_verified)
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                              <g clip-path="url(#clip0_3387_26479)">
                                 <path d="M7.99984 0.666626C6.96781 0.666626 6.08268 1.19705 5.5117 1.98101C4.54887 1.83055 3.54245 2.08367 2.813 2.81312C2.08243 3.54368 1.83522 4.55048 1.9869 5.50808C1.20431 6.08082 0.666504 6.96446 0.666504 7.99996C0.666504 9.03546 1.20431 9.9191 1.9869 10.4918C1.83522 11.4494 2.08243 12.4562 2.813 13.1868C3.54384 13.9176 4.55031 14.1641 5.50646 14.0169C6.08037 14.8008 6.96558 15.3333 7.99984 15.3333C9.03117 15.3333 9.92201 14.8033 10.4952 14.0172C11.4508 14.1638 12.4563 13.9171 13.1867 13.1868C13.9154 12.458 14.1694 11.4519 14.0188 10.4918C14.8016 9.9179 15.3332 9.03333 15.3332 7.99996C15.3332 6.96659 14.8016 6.08202 14.0188 5.50807C14.1694 4.54804 13.9154 3.54188 13.1867 2.81312C12.4584 2.08487 11.4532 1.83073 10.4937 1.98069C9.92048 1.19574 9.03028 0.666626 7.99984 0.666626Z" fill="#0284C7"></path>
                                 <path d="M10.7655 6.14544C10.9883 6.47175 10.9044 6.91691 10.5781 7.13973L10.516 7.18215C9.45671 7.90546 8.57549 8.85981 7.93872 9.97325C7.82808 10.1667 7.63359 10.2976 7.41269 10.3272C7.1918 10.3568 6.96972 10.2817 6.81204 10.1242L5.37632 8.69005C5.09677 8.4108 5.09653 7.95781 5.37578 7.67826C5.65503 7.39871 6.10803 7.39847 6.38758 7.67772L7.19287 8.48215C7.8746 7.51282 8.72627 6.67157 9.70906 6.00047L9.77118 5.95805C10.0975 5.73523 10.5427 5.81912 10.7655 6.14544Z" fill="white"></path>
                              </g>
                              <defs>
                                 <clipPath id="clip0_3387_26479">
                                       <rect width="16" height="16" fill="white"></rect>
                                 </clipPath>
                              </defs>
                           </svg>
                        @endif
                  </h4>
                  @php
                     // تعريب الأشهر
                     $months = [
                        1 => 'يناير', 2 => 'فبراير', 3 => 'مارس', 4 => 'أبريل',
                        5 => 'مايو', 6 => 'يونيو', 7 => 'يوليو', 8 => 'أغسطس',
                        9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر'
                     ];

                     $created = $business->user?->created_at;
                     $since = $created ? 'عضو منذ ' . ($months[$created->format('n')] ?? $created->format('F')) . ' ' . $created->format('Y') : '';
                  @endphp

                  @if($since)
                     <p><strong>{{ $since }}</strong></p>
                  @endif
               </div>
            </div>

            {{-- تم تعطيله الان / اتصل بنا --}} 
            {{-- <div x-data="contactForm" class="overview services shadow-sm no-margin d-none " bis_skin_checked="1">
               <h2 class="border-bottom">اتصل بنا</h2>
               <form @submit.prevent="handleSubmit">
                  <div x-show="success" class="alert alert-success m-3 mb-0" role="alert" bis_skin_checked="1" style="display: none;">
                     Your Message Submited Sucessfully
                  </div>
                  <div class="form-cover" bis_skin_checked="1">
                     <input type="text" @focus="removeError('name')" x-model="name" :class="{ 'is-invalid':  errors.name !== undefined }" class="form-control mb-0" placeholder="Full Name">
                     <div x-show="errors.name != undefined" class="invalid-feedback" x-text="errors.name" bis_skin_checked="1" style="display: none;"></div>
                     <input type="text" @focus="removeError('mobile')" x-model="mobile" :class="{ 'is-invalid':  errors.mobile !== undefined }" class="form-control mt-3 mb-0" placeholder="Enter Mobile Number">
                     <div x-show="errors.mobile != undefined" class="invalid-feedback" x-text="errors.mobile" bis_skin_checked="1" style="display: none;"></div>
                     <input type="text" @focus="removeError('email')" x-model="email" :class="{ 'is-invalid':  errors.email !== undefined }" class="form-control mt-3 mb-0" placeholder="Email Address ">
                     <div x-show="errors.email != undefined" class="invalid-feedback" x-text="errors.email" bis_skin_checked="1" style="display: none;"></div>
                     <textarea name="" @focus="removeError('message')" x-model="message" :class="{ 'is-invalid':  errors.message !== undefined }" placeholder="Enter Message" id="" class="form-control mt-3 mb-0" rows="4"></textarea>
                     <div x-show="errors.message != undefined" class="invalid-feedback" x-text="errors.message" bis_skin_checked="1" style="display: none;"></div>
                     <button x-show="!process" type="submit" class="btn btn-primary mt-3 w-100">Send Message</button>
                     <button x-show="process" disabled="true" class="btn btn-primary mt-3 w-100" style="display: none;">Send Message</button>
                  </div>
               </form>
            </div> --}}

            {{-- social Links --}}
            <div class="overview services shadow-sm no-margin " bis_skin_checked="1">

                  @if(!empty($business->facebook))
                     <h2 class="border-bottom"> الروابط الاجتماعية </h2>
                     <ul class="list-group social-link timilist list-group-flush">
                        <li class="list-group-item">
                              <a href="{{ $business->facebook }}" target="_blank" rel="nofollow">
                                 <i class="bi bi-facebook"></i> {{ $business->facebook }}
                              </a>
                        </li>
                  @endif

                  @if(!empty($business->twitter))
                     <li class="list-group-item">
                           <a href="{{ $business->twitter }}" target="_blank" rel="nofollow">
                              <i class="bi bi-twitter"></i> {{ $business->twitter }}
                           </a>
                     </li>
                  @endif

                  @if(!empty($business->instagram))
                     <li class="list-group-item">
                           <a href="{{ $business->instagram }}" target="_blank" rel="nofollow">
                              <i class="bi bi-instagram"></i> {{ $business->instagram }}
                           </a>
                     </li>
                  @endif

                  @if(!empty($business->linkedin))
                     <li class="list-group-item">
                           <a href="{{ $business->linkedin }}" target="_blank" rel="nofollow">
                              <i class="bi bi-linkedin"></i> {{ $business->linkedin }}
                           </a>
                     </li>
                  @endif

                  @if(!empty($business->youtube))
                     <li class="list-group-item">
                           <a href="{{ $business->youtube }}" target="_blank" rel="nofollow">
                              <i class="bi bi-youtube"></i> {{ $business->youtube }}
                           </a>
                     </li>
                  @endif
               </ul>

            </div>

            {{-- الفئة --}}
            <div class="overview services shadow-sm no-margin " bis_skin_checked="1">
               <h2 class="border-bottom">الفئة</h2>
               <ul class="list-group cateul list-group-flush">
                  <li class="list-group-item align-items-center">
                     <span>
                     @if($business->category && $business->category->image)
                        <img 
                           src="{{ asset('storage/' . $business->category->image) }}" 
                           alt="{{ $business->category->name }}" 
                        >
                     @endif

                     </span>
                        @if($business->category)
                           <span class="badge bg-primary">
                              {{ $business->category->name }}
                           </span>
                        @endif

                  </li>
               </ul>
            </div>

            {{-- اوقات الدوام --}}
            <div class="overview services shadow-sm no-margin " bis_skin_checked="1">
               @php
                  $days = [
                        'monday'    => 'الإثنين',
                        'tuesday'   => 'الثلاثاء',
                        'wednesday' => 'الأربعاء',
                        'thursday'  => 'الخميس',
                        'friday'    => 'الجمعة',
                        'saturday'  => 'السبت',
                        'sunday'    => 'الأحد',
                  ];

                  $arabic_time = function($time) {
                        $formatted = \Carbon\Carbon::parse($time)->format('h:i A');
                        $formatted = str_replace('AM', ' صباحاً ', $formatted);
                        $formatted = str_replace('PM', ' مساءً ', $formatted);
                        return $formatted;
                  };

                  // التحقق إذا يوجد يوم واحد على الأقل فيه وقت فتح وإغلاق
                  $has_open_days = $business->hours->whereNotNull('open_time')
                                                   ->whereNotNull('close_time')
                                                   ->count() > 0;
               @endphp

               @if($has_open_days)
                  {{-- اوقات الدوام --}}
                  <div class="overview services shadow-sm no-margin">
                        <h2 class="border-bottom">اوقات الدوام</h2>
                        <ul class="list-group">
                           @foreach($business->hours as $hour)
                              <li class="list-group-item">
                                    {{ $days[$hour->day] ?? $hour->day }}
                                    @if($hour->open_time && $hour->close_time)
                                       <span>
                                          {{ $arabic_time($hour->open_time) }}
                                          -
                                          {{ $arabic_time($hour->close_time) }}
                                       </span>
                                    @else
                                       <span style="color: red; font-weight: bold;">
                                          مغلق
                                       </span>
                                    @endif
                              </li>
                           @endforeach
                        </ul>
                  </div>
               @endif
            </div>


         </div>
      </div>
   </div>
</div>
{{-- End Second section --}}
@endsection