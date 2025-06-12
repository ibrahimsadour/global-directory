
{{-- Google SEO --}}
<title>@yield('title', setting('seo_meta_title', 'Global directory'))</title>
<meta name="description" content="@yield('seo_description', setting('seo_meta_description', 'Globaldirectory defult descriptio'))">
<meta name="keywords" content="@yield('seo_keyword', setting('seo_meta_keywords', 'Globaldirectory defult keywords'))">
<link rel="canonical" href="{{ url()->current() }}" />
<meta name="robots" content="index, follow">

{{-- End Google SEO --}}

{{-- Social Media SEO (Facebook / WhatsApp / Twitter) --}}
    <meta property="og:title" content="@yield('title', setting('seo_meta_title', 'Global directory'))">
    <meta property="og:description" content="@yield('seo_description', setting('seo_meta_description', 'Globaldirectory'))">
    <meta property="og:image" content="@yield('og:image', asset('storage/site-settings/default-banner.webp'))">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ setting('site_title', 'Global Directory') }}">
    <meta name="author" content="{{ setting('site_title', 'Global Directory') }}">
    <meta property="og:type" content="website">

{{-- End Social Media SEO (Facebook / WhatsApp / Twitter) --}}

{{-- Social Media SEO (Twitter) --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('title', setting('seo_meta_title', 'Global directory'))">
<meta name="twitter:description" content="@yield('seo_description', setting('seo_meta_description', 'Globaldirectory'))">
<meta name="twitter:image" content="@yield('og:image', asset('storage/site-settings/default-banner.webp'))">
{{-- End Social Media SEO (Twitter) --}}



