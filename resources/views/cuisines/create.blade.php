@extends('layouts.app')

@section('content')
<h1 class="h3 mb-3">Add Cuisine</h1>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('cuisines.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Cuisine name</label>
                <input name="name" value="{{ old('name') }}"
                       class="form-control @error('name') is-invalid @enderror" placeholder="e.g., Italian">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button class="btn btn-primary">Create</button>
            <a class="btn btn-link" href="{{ route('cuisines.index') }}">Cancel</a>
        </form>
    </div>
</div>
@endsection
