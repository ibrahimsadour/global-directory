@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
@endpush
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
    let mapInstance = null;
    let markerInstance = null;

    function initMap() {
        if (mapInstance) {
            mapInstance.invalidateSize();
            setTimeout(() => mapInstance.invalidateSize(), 100);
            return;
        }

        const latitudeInput = document.querySelector('[wire\\:model="data.latitude"]');
        const longitudeInput = document.querySelector('[wire\\:model="data.longitude"]');

        var latitude = latitudeInput?.value || 29.3759;
        var longitude = longitudeInput?.value || 47.9774;

        mapInstance = L.map('map').setView([latitude, longitude], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(mapInstance);

        markerInstance = L.marker([latitude, longitude], {
            draggable: true
        }).addTo(mapInstance);

        markerInstance.on('dragend', function (e) {
            var latlng = markerInstance.getLatLng();

            if (latitudeInput && longitudeInput) {
                latitudeInput.value = latlng.lat.toFixed(6);
                longitudeInput.value = latlng.lng.toFixed(6);

                latitudeInput.dispatchEvent(new Event('input', { bubbles: true }));
                longitudeInput.dispatchEvent(new Event('input', { bubbles: true }));
            }

const addressInput = document.querySelector('[wire\\:model="data.address"]');
if (addressInput) {
    const apiKey = '{{ env("GOOGLE_MAPS_API_KEY") }}';
    fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${latlng.lat},${latlng.lng}&key=${apiKey}&language=ar`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'OK') {
                // 1. فلترة النتائج الواقعية حسب نوعها
                let result = data.results.find(r =>
                    r.types.some(type =>
                        ['street_address', 'route', 'neighborhood', 'sublocality', 'locality'].includes(type)
                    ) &&
                    !r.formatted_address.match(/^\s*[A-Z0-9]+\+\w+/)
                );

                // 2. إذا لم نجد نتيجة مناسبة، استبعد Plus Code
                if (!result) {
                    result = data.results.find(r => !r.formatted_address.match(/^\s*[A-Z0-9]+\+\w+/));
                }

                // 3. fallback: استخدم أول نتيجة إذا لم تجد شيء آخر
                if (!result && data.results.length > 0) {
                    result = data.results[0];
                }

                // 4. إذا وجدنا نتيجة، حدث الحقل
                if (result && result.formatted_address) {
                    addressInput.value = result.formatted_address;
                } else {
                    addressInput.value = 'العنوان غير متوفر بدقة';
                }

                addressInput.dispatchEvent(new Event('input', { bubbles: true }));
            }
        })
        .catch(error => {
            console.error('Google Geocoding error:', error);
        });
}


        });

        if (latitudeInput && longitudeInput) {
            latitudeInput.addEventListener('change', function () {
                var lat = parseFloat(this.value) || 0;
                var lng = parseFloat(longitudeInput.value) || 0;
                markerInstance.setLatLng([lat, lng]);
                mapInstance.setView([lat, lng]);
            });

            longitudeInput.addEventListener('change', function () {
                var lng = parseFloat(this.value) || 0;
                var lat = parseFloat(latitudeInput.value) || 0;
                markerInstance.setLatLng([lat, lng]);
                mapInstance.setView([lat, lng]);
            });
        }

        setTimeout(() => {
            mapInstance.invalidateSize();
            setTimeout(() => mapInstance.invalidateSize(), 100);
        }, 100);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const interval = setInterval(() => {
            const mapElement = document.getElementById('map');
            if (mapElement && mapElement.offsetParent !== null) {
                initMap();
                clearInterval(interval);
            }
        }, 500);
    });
</script>
@endpush

<div wire:ignore id="map" style="width: 100%; height: 400px; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"></div>
