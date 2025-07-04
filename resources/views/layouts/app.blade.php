<!doctype html>
<html dir="rtl" lang="ar">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#ffffff">
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        @if(request()->has('page') && request()->get('page') > 1)
            <meta name="robots" content="noindex, follow">
        @endif
        {{-- السيو --}}
        <x-seo />
        
        {{-- السكيما --}}
        @yield('structured_data')

        {{--اكواد وقت الحاجة --}}
        {!! setting('code_snippet') !!}


        
        {{-- ملفات CSS عبر Vite --}}
        @vite(['resources/css/home.css', 'resources/js/home.js'])

        {{-- أي ملفات أيقونات خارجية أو خطوط --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        {{-- اكواد للخريطة --}}
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

        {{-- ايقونة الموقع --}}
        <link rel="icon" type="image/png" href="{{ setting('site_favicon') ? asset('storage/' . setting('site_favicon')) : asset('storage/site-settings/site_favicon') }}">

    
        <script>
            function handleClick(like, id) {
                axios.post('update-bookmark', {'id':id,'like':!like});
                return !like;
            }
        </script>
        
        {{-- أي ستايل إضافي --}}
        @stack('styles')
    </head>


   <body>

        {{-- الهيدر --}}
        <x-header />

        {{-- محتوى الصفحة --}}
        <main>
            @yield('content')
        </main>

        {{-- الفوتر --}}
        <x-footer />
        <x-bottom-navigation />


        {{-- المودال --}}
        <x-login-modal />


        {{-- هنا سيجمع كل السكريبتات التي تم دفعها من الصفحات الفرعية --}}
        @stack('scripts')

    </body>
</html>