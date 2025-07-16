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
<div class="w-full bg-gray-50 py-6">
   <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
      <!-- ✅ Sidebar & Content داخل Livewire -->
         @livewire('business-list', ['categorySlug' => $category->slug])
  </div>
</div>
{{-- End Second section --}}
@endsection