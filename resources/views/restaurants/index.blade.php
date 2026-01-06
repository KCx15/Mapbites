@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Restaurants</h1>
    <a class="btn btn-primary" href="{{ route('restaurants.create') }}">Add Restaurant</a>
</div>

<form class="row g-2 align-items-end mb-3" method="GET" action="{{ route('restaurants.index') }}">
    <div class="col-md-4">
        <label class="form-label">Cuisine</label>
        <select name="cuisine" class="form-select">
            <option value="">All cuisines</option>
            @foreach($cuisines as $cuisine)
                <option value="{{ $cuisine->slug }}" @selected(request('cuisine') === $cuisine->slug)>
                    {{ $cuisine->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Sort by</label>
        <select name="sort" class="form-select">
            <option value="name" @selected(request('sort','name')==='name')>Name</option>
            <option value="rating" @selected(request('sort')==='rating')>Rating</option>
            <option value="created_at" @selected(request('sort')==='created_at')>Newest</option>
        </select>
    </div>

    <div class="col-md-2">
        <label class="form-label">Direction</label>
        <select name="dir" class="form-select">
            <option value="asc" @selected(request('dir','asc')==='asc')>Asc</option>
            <option value="desc" @selected(request('dir')==='desc')>Desc</option>
        </select>
    </div>

    <div class="col-md-2 d-flex gap-2">
        <button class="btn btn-dark w-100" type="submit">Apply</button>
        <a class="btn btn-outline-secondary w-100" href="{{ route('restaurants.index') }}">Reset</a>
    </div>
</form>

@include('restaurants._table', ['restaurants' => $restaurants])
@endsection
