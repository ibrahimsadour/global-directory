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

                // Important: notify Livewire of change
                latitudeInput.dispatchEvent(new Event('input', { bubbles: true }));
                longitudeInput.dispatchEvent(new Event('input', { bubbles: true }));
            }

            // ✅ NEW: Get address via reverse geocoding
            const addressInput = document.querySelector('[wire\\:model="data.address"]');
            if (addressInput) {
                fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latlng.lat}&lon=${latlng.lng}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.display_name) {
                            addressInput.value = data.display_name;
                            addressInput.dispatchEvent(new Event('input', { bubbles: true }));
                        }
                    })
                    .catch(error => {
                        console.error('Reverse Geocoding error:', error);
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

        // حل freeze
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
