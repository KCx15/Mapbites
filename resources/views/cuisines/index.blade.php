@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Cuisines</h1>
    <a class="btn btn-primary" href="{{ route('cuisines.create') }}">Add Cuisine</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($cuisines as $cuisine)
                <tr>
                    <td>{{ $cuisine->name }}</td>
                    <td><code>{{ $cuisine->slug }}</code></td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('cuisines.edit', $cuisine) }}">Edit</a>

                        <form class="d-inline" method="POST" action="{{ route('cuisines.destroy', $cuisine) }}"
                              onsubmit="return confirm('Delete this cuisine?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center py-4">No cuisines yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
