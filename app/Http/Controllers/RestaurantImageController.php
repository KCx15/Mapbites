<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\RestaurantImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestaurantImageController extends Controller
{
    public function store(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'], // 4MB
            'caption' => ['nullable', 'string', 'max:120'],
        ]);

        $folder = 'restaurants/' . $restaurant->slug;

        $path = $request->file('image')->store($folder, 'public');

        $restaurant->images()->create([
            'path' => $path,
            'caption' => $validated['caption'] ?? null,
        ]);

        return back()->with('success', 'Image uploaded.');
    }

    public function destroy(Restaurant $restaurant, RestaurantImage $image)
    {
        // safety: ensure image belongs to this restaurant
        if ($image->restaurant_id !== $restaurant->id) {
            abort(404);
        }

        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('success', 'Image deleted.');
    }
}
