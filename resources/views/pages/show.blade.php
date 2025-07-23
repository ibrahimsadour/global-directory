@extends('layouts.app')

{{-- ✅ تهيئة بيانات الميتا للسيو --}}
@section('title', $page->meta_title ?? setting('seo_meta_title') . ' | ' . $page->title)
@section('seo_description', $page->meta_description ?? setting('seo_meta_description') . ' | ' . $page->title)
@section('og:image', $page->image ? asset('storage/' . $page->image) : asset('storage/site-settings/default-banner.webp'))

{{-- ✅ بيانات Structured Data لمحركات البحث --}}
@section('structured_data')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "{{ $page->title }} | {{ setting('site_title', 'DalilGo') }}",
  "description": "{{ $page->meta_description ?? 'صفحة من موقع دليل غو تحتوي على معلومات مهمة' }}",
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
        "name": "{{ $page->title }}",
        "item": "{{ url()->current() }}"
      }
    ]
  }
}
</script>
@endsection

@section('content')

{{-- ✅ مسار التنقل (breadcrumb) --}}
<x-breadcrumb :items="[
    ['title' => 'الرئيسية', 'url' => url('/')],
    ['title' => $page->title]
]" />

{{-- ✅ محتوى الصفحة --}}
<div class="container py-8 max-w-4xl mx-auto">

    {{-- ✅ عنوان الصفحة --}}
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">{{ $page->title }}</h1>

    {{-- ✅ إظهار الصورة فقط إذا لم تكن مضمنة داخل المحتوى --}}
    @php
        $imageInContent = Str::contains($page->content, $page->image);
    @endphp

    @if($page->image && !$imageInContent)
        <img src="{{ asset('storage/' . $page->image) }}" alt="{{ $page->title }}"
            loading="lazy" class="rounded-xl mb-6 max-h-96 w-full object-cover">
    @endif

    {{-- ✅ عرض محتوى الصفحة (HTML من لوحة التحكم) --}}
    <div class="prose prose-blue max-w-none rtl text-gray-800 leading-loose
        prose-h2:text-2xl prose-h3:text-xl prose-p:leading-relaxed prose-blockquote:border-s-4 prose-blockquote:border-blue-400 prose-blockquote:ps-4 prose-code:bg-gray-100 prose-code:px-1.5 prose-code:py-1 prose-code:rounded">
        {!! $page->content !!}
    </div>

    {{-- ✅ روابط المشاركة الاجتماعية --}}
    <x-share-buttons :title="$page->title" />

</div>
@endsection
