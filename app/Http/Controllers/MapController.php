<?php

namespace App\Http\Controllers;

use App\Models\Cuisine;     
use App\Models\Restaurant;
use Illuminate\Http\Request;

class MapController extends Controller
{
 public function index(Request $request)
    {
        $cuisines = Cuisine::orderBy('name')->get();

        $query = Restaurant::with('cuisine')
            ->whereNotNull('lat')
            ->whereNotNull('lng');

        if ($request->filled('cuisine')) {
            $query->whereHas('cuisine', function ($q) use ($request) {
                $q->where('slug', $request->cuisine);
            });
        }

        $restaurants = $query->orderBy('name')->get();

        return view('map.index', compact('restaurants', 'cuisines'));
    }

}
