<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
  public function index()
{
    $restaurants = \App\Models\Restaurant::with('cuisine')
        ->whereNotNull('lat')->whereNotNull('lng')
        ->orderBy('name')
        ->get();

    $cuisines = \App\Models\Cuisine::orderBy('name')->get();

    return view('map.index', compact('restaurants', 'cuisines'));
}

}
