<script>
    document.addEventListener('DOMContentLoaded', function () {
        const latitude = @json($business->latitude ?? 29.3759);
        const longitude = @json($business->longitude ?? 47.9774);
        const address = @json($business->address ?? '');

        if (!isNaN(latitude) && !isNaN(longitude)) {
            const map = L.map('map').setView([latitude, longitude], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const marker = L.marker([latitude, longitude]).addTo(map);

            if (address) {
            marker.bindPopup(address).openPopup();
            }

            L.control.scale().addTo(map);
        }
    });
</script>

<div class=" shadow-sm overview mt-4">
    <h2 class="border-bottom">العنوان على الخريطة</h2>
    <div id="map" style="width: 100%; height: 350px; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"></div>
</div>