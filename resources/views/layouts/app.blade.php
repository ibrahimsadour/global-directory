<!doctype html>
<html dir="rtl" lang="ar">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />

   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>@yield('title', 'Smart Directory')</title>

      <meta name="keywords" content="smart-directory, business directory, business listing">
      <meta name="author" content="Smarteye Technologies">
      <meta name="description" content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce placerat rhoncus dolor feugiat semper. Vestibulum imperdiet purus nibh, ut finibus dolor lobortis quis. Vivamus et blandit urna. Aliquam mi arcu, sagittis nec tortor vel">
      {{-- ملفات CSS عبر Vite --}}
      @vite(['resources/css/home.css', 'resources/js/home.js'])

      {{-- أي ملفات أيقونات خارجية أو خطوط --}}
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

      {{-- اكواد للخريطة --}}
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
      <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

      <meta property=og:url content="index.html">
      <meta property=og:type content="website">
      <meta property=og:sitename content="Laravel">
   
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


        {{-- المودال --}}
        <x-login-modal />


        {{-- هنا سيجمع كل السكريبتات التي تم دفعها من الصفحات الفرعية --}}
        @stack('scripts')

    </body>

</html>