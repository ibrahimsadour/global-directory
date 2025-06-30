@extends('layouts.app')

{{-- السيو الافتراضي الخاص بالموقع --}}

@section('structured_data')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "{{ setting('site_title', 'Global Directory') }}",
  "url": "{{ url('/') }}",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "{{ url('/') }}?s={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "{{ setting('site_title', 'Global Directory') }}",
  "url": "{{ url('/') }}",
  "logo": "{{ setting('site_logo') ? asset('storage/' . setting('site_logo')) : asset('storage/site-settings/default-logo.webp') }}"
}
</script>

@endsection

@section('content')

    {{-- عرض الهيدر --}}
    @include('components.home.header')


    {{-- عرض الفئات --}}
    @include('components.home.category')


    {{-- عرض الاعلانات المميزة --}}
    @include('components.home.featured-listing')

    
    {{-- عرض المحافظات --}}
    @include('components.home.governorate')


    {{-- عرض اخر الاعلانات المضافة --}}
    @include('components.home.last-listing')


    {{-- الأخبار والنصائح --}}
    @include('components.home.latest-blog')


  
@endsection

@push('styles')
   
@endpush

@push('scripts')
    <script>
         function handleClick(e) {
             // Now you can access the event object (e) directly
         }
    </script> 
    <script>
         function handleClick(like, id) {
             axios.post('update-bookmark', {'id':id,'like':!like});
             return !like;
         }
    </script>
    <script>
         function handleChange(){
            document.getElementById("location").submit();
         }
    </script>

@endpush