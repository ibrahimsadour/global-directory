<div class="mt-10">
    <h3 class="text-lg font-semibold mb-4 text-gray-800">مشاركة الصفحة:</h3>
    <div class="flex flex-wrap gap-3">

        {{-- فيسبوك --}}
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}"
           target="_blank"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition text-sm">
            <i class="bi bi-facebook"></i> فيسبوك
        </a>

        {{-- تويتر (X) --}}
        <a href="https://twitter.com/intent/tweet?url={{ urlencode($url) }}&text={{ urlencode($title) }}"
           target="_blank"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-400 text-white hover:bg-blue-500 transition text-sm">
            <i class="bi bi-twitter-x"></i> تويتر
        </a>

        {{-- واتساب --}}
        <a href="https://api.whatsapp.com/send?text={{ urlencode($title . ' ' . $url) }}"
           target="_blank"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-500 text-white hover:bg-green-600 transition text-sm">
            <i class="bi bi-whatsapp"></i> واتساب
        </a>

        {{-- تيليجرام --}}
        <a href="https://t.me/share/url?url={{ urlencode($url) }}&text={{ urlencode($title) }}"
           target="_blank"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600 transition text-sm">
            <i class="bi bi-telegram"></i> تيليجرام
        </a>
    </div>
</div>
