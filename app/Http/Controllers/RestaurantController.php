<?php

namespace App\Http\Controllers;
use App\Models\Cuisine;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;


class RestaurantController extends Controller
{


public function show(\App\Models\Restaurant $restaurant)
{
    $restaurant->load(['cuisine', 'images']);
    return view('restaurants.show', compact('restaurant'));
}



public function create()
{
    $cuisines = Cuisine::orderBy('name')->get();
    return view('restaurants.create', compact('cuisines'));
}

public function index(Request $request)
{
    $cuisines = \App\Models\Cuisine::orderBy('name')->get();

    $query = \App\Models\Restaurant::with('cuisine');

    
    if ($request->filled('cuisine')) {
        $query->whereHas('cuisine', function ($q) use ($request) {
            $q->where('slug', $request->cuisine);
        });
    }

    
    $allowedSorts = ['name', 'rating', 'created_at'];
    $sort = in_array($request->get('sort'), $allowedSorts) ? $request->get('sort') : 'name';

    $dir = strtolower($request->get('dir', 'asc'));
    $dir = in_array($dir, ['asc', 'desc']) ? $dir : 'asc';

    $restaurants = $query->orderBy($sort, $dir)->get();

    return view('restaurants.index', compact('restaurants', 'cuisines', 'sort', 'dir'));
}


public function store(Request $request)
{
    $validated = $request->validate([
        'cuisine_id' => ['required', 'exists:cuisines,id'],
        'name' => ['required', 'string', 'max:120'],
        'address' => ['required', 'string', 'max:255'],
        'lat' => ['nullable', 'numeric', 'between:-90,90'],
        'lng' => ['nullable', 'numeric', 'between:-180,180'],
        'rating' => ['nullable', 'numeric', 'between:0,5'],
        'description' => ['nullable', 'string'],
    ]);

    $slug = Str::slug($validated['name']);
    $geo = $this->geocodeAddress($validated['address']);

if (!$geo) {
    throw ValidationException::withMessages([
        'address' => 'Address not found. Please enter a more specific address.',
    ]);
}

if (empty($validated['lat']) || empty($validated['lng'])) {
    $validated['lat'] = $geo['lat'];
    $validated['lng'] = $geo['lng'];
}

    $base = $slug;
    $i = 2;
    while (\App\Models\Restaurant::where('slug', $slug)->exists()) {
        $slug = $base.'-'.$i++;
    }

    \App\Models\Restaurant::create([
        ...$validated,
        'slug' => $slug,
        'rating' => $validated['rating'] ?? 0.0,
    ]);

  return redirect()->route('restaurants.index')
    ->with('success', 'Restaurant created successfully.')
    ->with('matched_address', $geo['display_name'] ?? null);

}

public function edit(\App\Models\Restaurant $restaurant)
{
    $cuisines = Cuisine::orderBy('name')->get();
    return view('restaurants.edit', compact('restaurant', 'cuisines'));
}

public function update(Request $request, \App\Models\Restaurant $restaurant)
{
    $validated = $request->validate([
        'cuisine_id' => ['required', 'exists:cuisines,id'],
        'name' => ['required', 'string', 'max:120'],
        'address' => ['required', 'string', 'max:255'],
        'lat' => ['nullable', 'numeric', 'between:-90,90'],
        'lng' => ['nullable', 'numeric', 'between:-180,180'],
        'rating' => ['nullable', 'numeric', 'between:0,5'],
        'description' => ['nullable', 'string'],
    ]);

    $slug = Str::slug($validated['name']);

    $geo = $this->geocodeAddress($validated['address']);

if (!$geo) {
    throw ValidationException::withMessages([
        'address' => 'Address not found. Please enter a more specific address.',
    ]);
}


if (empty($validated['lat']) || empty($validated['lng'])) {
    $validated['lat'] = $geo['lat'];
    $validated['lng'] = $geo['lng'];
}

    $base = $slug;
    $i = 2;
    while (\App\Models\Restaurant::where('slug', $slug)->where('id', '!=', $restaurant->id)->exists()) {
        $slug = $base.'-'.$i++;
    }

    $restaurant->update([
        ...$validated,
        'slug' => $slug,
        'rating' => $validated['rating'] ?? $restaurant->rating,
    ]);

      return redirect()->route('restaurants.index')
    ->with('success', 'Restaurant created successfully.')
    ->with('matched_address', $geo['display_name'] ?? null);
}

public function destroy(\App\Models\Restaurant $restaurant)
{
    $restaurant->delete();
    return redirect()->route('restaurants.index')->with('success', 'Restaurant deleted successfully.');
}
private function geocodeAddress(string $address): ?array
{
    $response = Http::withHeaders([
        'User-Agent' => 'MapBites/1.0 (student project)',
    ])->get('https://nominatim.openstreetmap.org/search', [
        'q' => $address,
        'format' => 'json',
        'limit' => 1,
    ]);

    if (!$response->successful()) {
        return null;
    }

    $data = $response->json();

    if (!is_array($data) || count($data) === 0) {
        return null;
    }

    return [
        'lat' => (float) $data[0]['lat'],
        'lng' => (float) $data[0]['lon'],
        'display_name' => $data[0]['display_name'] ?? null,
    ];
}


}
