@extends('layouts.app')

@section('content')
<h1 class="h3 mb-3">Edit Cuisine</h1>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('cuisines.update', $cuisine) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Cuisine name</label>
                <input name="name" value="{{ old('name', $cuisine->name) }}"
                       class="form-control @error('name') is-invalid @enderror">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button class="btn btn-primary">Save</button>
            <a class="btn btn-link" href="{{ route('cuisines.index') }}">Cancel</a>
        </form>
    </div>
</div>
@endsection
