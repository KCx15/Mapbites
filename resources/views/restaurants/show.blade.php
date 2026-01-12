@extends('layouts.app')

@section('content')
<h1 class="h3 mb-2">{{ $restaurant->name }}</h1>
<div class="text-muted mb-3">
    {{ $restaurant->cuisine?->name }} • <code>{{ $restaurant->slug }}</code>
</div>

{{-- Restaurant info --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="mb-2"><strong>Address:</strong> {{ $restaurant->address }}</div>

        <div class="mb-2">
            <strong>Rating:</strong>
            @include('partials.rating-stars', ['value' => $restaurant->rating])
        </div>

        @if($restaurant->lat && $restaurant->lng)
            <div class="mb-2">
                <strong>Coordinates:</strong> {{ $restaurant->lat }}, {{ $restaurant->lng }}
            </div>
        @endif

        @if($restaurant->description)
            <div class="mt-3">{{ $restaurant->description }}</div>
        @endif
    </div>
</div>

{{-- Photos --}}
<h2 class="h5 mb-3">Photos</h2>

<form class="mb-3" method="POST"
      action="{{ route('restaurants.images.store', $restaurant) }}"
      enctype="multipart/form-data">
    @csrf

    <div class="row g-2 align-items-end">
        <div class="col-md-6">
            <label class="form-label">Upload image</label>
            <input type="file" name="image"
                   class="form-control @error('image') is-invalid @enderror"
                   accept="image/*">
            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">Caption (optional)</label>
            <input type="text" name="caption"
                   class="form-control @error('caption') is-invalid @enderror"
                   value="{{ old('caption') }}">
            @error('caption') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-2">
            <button class="btn btn-dark w-100" type="submit">Upload</button>
        </div>
    </div>
</form>

<div class="row g-3 mb-4">
@forelse($restaurant->images as $img)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="card shadow-sm h-100">
            <img src="{{ asset('storage/'.$img->path) }}"
                 class="card-img-top"
                 alt="{{ $img->caption ?? 'Restaurant photo' }}">

            <div class="card-body p-2">
                @if($img->caption)
                    <div class="small mb-2">{{ $img->caption }}</div>
                @endif

                <form method="POST"
                      action="{{ route('restaurants.images.destroy', [$restaurant, $img]) }}"
                      onsubmit="return confirm('Delete this image?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger w-100">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
@empty
    <div class="text-muted">No photos uploaded yet.</div>
@endforelse
</div>

{{-- Location map (ONLY ONCE) --}}
@if($restaurant->lat && $restaurant->lng)
    <hr class="my-4">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2 class="h5 mb-0">Location</h2>

        <a class="btn btn-sm btn-outline-primary"
           target="_blank"
           href="https://www.google.com/maps?q={{ $restaurant->lat }},{{ $restaurant->lng }}">
            Open in Google Maps
        </a>
    </div>

    <div id="restaurantMap"
         class="rounded shadow-sm"
         style="height: 350px;"></div>

    {{-- Leaflet --}}
    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const lat = {{ $restaurant->lat }};
            const lng = {{ $restaurant->lng }};

            const map = L.map('restaurantMap').setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            L.marker([lat, lng])
                .addTo(map)
                .bindPopup(
                    `<strong>{{ addslashes($restaurant->name) }}</strong><br>{{ addslashes($restaurant->address) }}`
                )
                .openPopup();
        });
    </script>
@else
    <div class="alert alert-warning mt-4">
        No coordinates available for this restaurant yet.
        Edit the address to generate coordinates.
    </div>
@endif

{{-- Actions --}}
<div class="mt-4">
    <a class="btn btn-outline-secondary"
       href="{{ route('restaurants.edit', $restaurant) }}">
        Edit
    </a>
    <a class="btn btn-link"
       href="{{ route('restaurants.index') }}">
        Back
    </a>
</div>
@endsection
