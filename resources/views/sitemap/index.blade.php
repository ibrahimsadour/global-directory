<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ url('/sitemap-home.xml') }}</loc>
        <lastmod>{{ \Carbon\Carbon::now()->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ url('/sitemap-categories.xml') }}</loc>
        <lastmod>{{ \Carbon\Carbon::now()->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ url('/sitemap-governorates.xml') }}</loc>
        <lastmod>{{ \Carbon\Carbon::now()->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ url('/sitemap-business.xml') }}</loc>
        <lastmod>{{ \Carbon\Carbon::now()->toAtomString() }}</lastmod>
    </sitemap>
</sitemapindex>
