@extends('layouts.app')

@section('content')
<h1 class="h3 mb-2">{{ $restaurant->name }}</h1>
<div class="text-muted mb-3">{{ $restaurant->cuisine?->name }} • <code>{{ $restaurant->slug }}</code></div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="mb-2"><strong>Address:</strong> {{ $restaurant->address }}</div>
        <div class="mb-2"><strong>Rating:</strong> {{ number_format((float)$restaurant->rating, 1) }}</div>
        @if($restaurant->lat && $restaurant->lng)
            <div class="mb-2"><strong>Coordinates:</strong> {{ $restaurant->lat }}, {{ $restaurant->lng }}</div>
        @endif
        @if($restaurant->description)
            <div class="mt-3">{{ $restaurant->description }}</div>
        @endif
    </div>
</div>

<div class="mt-3">
    <a class="btn btn-outline-secondary" href="{{ route('restaurants.edit', $restaurant) }}">Edit</a>
    <a class="btn btn-link" href="{{ route('restaurants.index') }}">Back</a>
</div>
@endsection
