@extends('layouts.app')

@section('content')
<h1 class="h3 mb-3">MapBites – Restaurant Map</h1>

<p class="text-muted">
    Browse restaurants on the map. Click a marker to view details.
</p>

<div id="map" style="height: 600px;" class="rounded shadow-sm"></div>

{{-- Pass PHP data to JS safely --}}
<script>
    const restaurants = @json($restaurants);
</script>

{{-- Leaflet CSS --}}
<link
  rel="stylesheet"
  href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

{{-- Leaflet JS --}}
<script
  src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Initialize map (Malta-ish default, adjust if needed)
    const map = L.map('map').setView([35.8978, 14.5125], 11);

    // OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Add markers
    restaurants.forEach(r => {
        if (!r.lat || !r.lng) return;

        const popup = `
            <strong>${r.name}</strong><br>
            ${r.cuisine ? r.cuisine.name : ''}<br>
            <a href="/restaurants/${r.slug}">View details</a>
        `;

        L.marker([r.lat, r.lng])
            .addTo(map)
            .bindPopup(popup);
    });
});
</script>
@endsection
