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
<div class="container-fluid single-container">
   <div class="container">
      <div class="row">
         <div class="col-md-8">

            {{-- معلومات النشاط الرئيسية --}}
            @include('business.partials.details')

            {{-- <div class="overview shadow-sm no-margin row">
               <div class="details p-3 border-bottom">
                  <p class="mb-2">{{ $business->description }}</p>
               </div>
            </div> --}}
            
            {{-- الخدمات --}}
            @include('business.partials.services')

            {{-- المنتجات--}}
            @include('business.partials.products')



            {{-- معرض الصوور --}}
            @include('business.partials.gallery')



            {{-- التقيمات --}}
            @include('business.partials.review')

         </div>
         
         <div class="col-md-4 sidecl">

            {{-- الخريطة --}}
            @include('business.partials.map')

            
            {{-- صاحب النشاط --}}
            @include('business.partials.postedby')


            {{-- تم تعطيله الان / اتصل بنا --}} 
            {{-- @include('business.partials.contact-form') --}}


            {{-- social Links --}}
            @include('business.partials.social-link')

            {{-- الفئة --}}
            @include('business.partials.category')


            {{-- اوقات الدوام --}}
            @include('business.partials.timing')



         </div>
      </div>
   </div>
</div>
{{-- End Second section --}}
@endsection

@pushOnce('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('review', () => ({
        message: '',
        star: 3,
        lid: {{ $bid }},
        uid: {{ auth()->user()->id ?? 0 }},
        error: {},
        reviews: [],
        loading: true, // ✅ نبدأ التحميل
        process: false,
        success: false,
        offset: 0,
        showMore: true,
        removeId: 0,
        edit: -1,

        // ✅ الإضافات الجديدة
        avg: 0,
        total: 0,

        init() {
            this.loadReviews();
        },
        formatSince(dateStr) {
            const now = new Date();
            const past = new Date(dateStr);
            const diffSeconds = Math.floor((now - past) / 1000);

            const minute = 60;
            const hour = 60 * minute;
            const day = 24 * hour;
            const week = 7 * day;
            const month = 30 * day;
            const year = 365 * day;

            if (diffSeconds < minute) return 'منذ لحظات';
            if (diffSeconds < hour) return `منذ ${Math.floor(diffSeconds / minute)} دقيقة`;
            if (diffSeconds < day) return `منذ ${Math.floor(diffSeconds / hour)} ساعة`;
            if (diffSeconds < week) return `منذ ${Math.floor(diffSeconds / day)} يوم`;
            if (diffSeconds < month) {
                const weeks = Math.floor(diffSeconds / week);
                return weeks === 1 ? 'منذ أسبوع' : `منذ ${weeks} أسابيع`;
            }
            if (diffSeconds < year) {
                const months = Math.floor(diffSeconds / month);
                if (months === 1) return 'منذ شهر';
                if (months === 2) return 'منذ شهرين';
                if (months <= 10) return `منذ ${months} أشهر`;
                return `منذ ${months} شهر`;
            }

            const years = Math.floor(diffSeconds / year);
            if (years === 1) return 'منذ سنة';
            if (years === 2) return 'منذ سنتين';
            if (years <= 10) return `منذ ${years} سنوات`;
            return `منذ ${years} سنة`;
        },


        addStar(s) {
            this.star = s;
        },

        removeRating(index) {
            this.removeId = index;
        },

        confirmRemove() {
            const rid = this.reviews[this.removeId].id;
            axios.delete(`/user/deleterating/${rid}`).then(() => {
                window.location.reload();
            }).catch((err) => {
                console.error('❌ فشل الحذف:', err);
            });
        },

        editReview(index) {
            this.edit = index;
        },

        updateReview(index) {
            axios.put(`/user/updaterating/${this.reviews[index].id}`, this.reviews[index]).then(() => {
                this.edit = -1;
            });
        },

        postReview() {
            this.error = {};
            this.success = false;

            if (this.message.trim().length < 5) {
                this.error.message = "الرسالة يجب أن تكون 5 أحرف على الأقل.";
                return;
            }

            this.process = true;

            axios.post('/user/rating', {
                business_id: this.lid,
                rating: this.star,
                message: this.message
            }).then((e) => {
                this.process = false;
                this.offset = 0;
                this.loadReviews();
                this.addStar(3);
                this.message = '';
                this.error = {};
                this.success = true;
            }).catch((error) => {
                console.error('Validation Error:', error.response?.data);
                this.process = false;

                if (error.response?.status === 422) {
                    const err = error.response.data.error;
                    this.error.message = typeof err === 'string' ? err : err.message;
                }
            });
        },

        loadMoreReviews() {
            axios.get(`/getMoreReviews/${this.lid}/${this.offset}`).then((e) => {
                this.reviews.push(...e.data.reviews);
                this.offset++;
                this.showMore = e.data.reviews.length >= 3;
            });
        },

        loadReviews() {
            axios.get(`/getMoreReviews/${this.lid}/0`).then((response) => {
                this.reviews = response.data.reviews;
                this.avg = response.data.average;
                this.total = response.data.count;
                this.loading = false; // ✅ انتهى التحميل
            });
        }
    }));
});
</script>
@endPushOnce