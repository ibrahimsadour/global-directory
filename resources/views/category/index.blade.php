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
{{-- Begin Second section --}}
<div class="w-full bg-gray-50 py-6">
   <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
      <!-- ✅ Sidebar & Content داخل Livewire -->
    @livewire('business-list')
   </div>
</div>

{{-- End Second section --}}
@endsection