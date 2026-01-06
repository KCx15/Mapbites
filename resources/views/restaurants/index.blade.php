@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Restaurants</h1>
    <a class="btn btn-primary" href="{{ route('restaurants.create') }}">Add Restaurant</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Cuisine</th>
                    <th>Rating</th>
                    <th>Address</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($restaurants as $restaurant)
                <tr>
                    <td>
                        <a href="{{ route('restaurants.show', $restaurant) }}">
                            {{ $restaurant->name }}
                        </a>
                        <div class="text-muted small"><code>{{ $restaurant->slug }}</code></div>
                    </td>
                    <td>{{ $restaurant->cuisine?->name }}</td>
                    <td>{{ number_format((float)$restaurant->rating, 1) }}</td>
                    <td>{{ $restaurant->address }}</td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('restaurants.edit', $restaurant) }}">Edit</a>

                        <form class="d-inline" method="POST" action="{{ route('restaurants.destroy', $restaurant) }}"
                              onsubmit="return confirm('Delete this restaurant?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-4">No restaurants yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
