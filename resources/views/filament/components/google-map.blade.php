@if ($getRecord()->latitude && $getRecord()->longitude)
    <div wire:ignore>
        <div id="map" style="height: 600px; width: 100%; border-radius: 8px;"></div>
    </div>

    @push('scripts')
        <script>
            let map;
            let marker;

            function initMap() {
                // Get the record data
                const record = @json($getRecord());

                const address = record.address.full_address;

                const lat = parseFloat(record.latitude);
                const lng = parseFloat(record.longitude);

                // Initialize map
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 15,
                    center: { lat: lat, lng: lng },
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                // Add marker
                marker = new google.maps.Marker({
                    position: { lat: lat, lng: lng },
                    map: map,
                    title: record.name || 'Location'
                });

                // Add info window
                const infoWindow = new google.maps.InfoWindow({
                    content: `
                <div style="padding: 10px;color:#000;font-size:14px;">
                    <h3 style="margin: 0 0 5px 0;font-size:18px;font-weight:bold">${record.name || 'Location'}</h3>
                    ${address ? `<p style="margin: 0;">${address.replaceAll(', ', '<br/>')}</p>` : ''}
                </div>
            `
                });

                marker.addListener('click', () => {
                    infoWindow.open(map, marker);
                });
            }

            // Initialize map when the page loads
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof google !== 'undefined') {
                    initMap();
                }
            });

        </script>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.api_key') }}&callback=initMap">
        </script>
    @endpush
@endif
