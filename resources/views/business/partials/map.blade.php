<!-- ✅ عرض الخريطة -->
<div class="overview mt-4 px-3 pb-3">
    <h2 class="border-bottom mb-2 homepage-title">العنوان على الخريطة</h2>
    <div id="map" style="
        width: 100%;
        height: 300px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        z-index: 10;
        position: relative;
    "></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const latitude = @json($business->latitude ?? 29.3759);
    const longitude = @json($business->longitude ?? 47.9774);
    const address = @json($business->address ?? '');

    let mapInitialized = false;

    const loadMap = () => {
        if (mapInitialized) return;

        const map = L.map('map').setView([latitude, longitude], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const marker = L.marker([latitude, longitude]).addTo(map);

        if (address) {
            marker.bindPopup(address).openPopup();
        }

        L.control.scale().addTo(map);
        mapInitialized = true;
    };

    // ✅ Lazy Load باستخدام IntersectionObserver
    const mapElement = document.getElementById('map');
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    loadMap();
                    observer.unobserve(mapElement); // نوقف المراقبة بعد التحميل
                }
            });
        }, {
            rootMargin: '0px 0px 200px 0px', // تحميل قبل الظهور الكامل بـ200px
        });

        observer.observe(mapElement);
    } else {
        // المتصفح لا يدعم IntersectionObserver، نحمل الخريطة مباشرة
        loadMap();
    }
});
</script>
