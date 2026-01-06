@extends('layouts.app')

@section('content')
<h1 class="h3 mb-3">Edit Restaurant</h1>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('restaurants.update', $restaurant) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Cuisine</label>
                <select name="cuisine_id" class="form-select @error('cuisine_id') is-invalid @enderror">
                    <option value="">Choose cuisine...</option>
                    @foreach($cuisines as $cuisine)
                        <option value="{{ $cuisine->id }}"
                            @selected(old('cuisine_id', $restaurant->cuisine_id) == $cuisine->id)>
                            {{ $cuisine->name }}
                        </option>
                    @endforeach
                </select>
                @error('cuisine_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Restaurant name</label>
                <input name="name" value="{{ old('name', $restaurant->name) }}"
                       class="form-control @error('name') is-invalid @enderror">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <input name="address" value="{{ old('address', $restaurant->address) }}"
                       class="form-control @error('address') is-invalid @enderror">
                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Latitude (optional)</label>
                    <input name="lat" value="{{ old('lat', $restaurant->lat) }}"
                           class="form-control @error('lat') is-invalid @enderror">
                    @error('lat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Longitude (optional)</label>
                    <input name="lng" value="{{ old('lng', $restaurant->lng) }}"
                           class="form-control @error('lng') is-invalid @enderror">
                    @error('lng') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Rating (0–5)</label>
                <input name="rating" value="{{ old('rating', $restaurant->rating) }}"
                       class="form-control @error('rating') is-invalid @enderror">
                @error('rating') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description (optional)</label>
                <textarea name="description" rows="4"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $restaurant->description) }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button class="btn btn-primary">Save</button>
            <a class="btn btn-link" href="{{ route('restaurants.index') }}">Cancel</a>
        </form>
    </div>
</div>
@endsection
