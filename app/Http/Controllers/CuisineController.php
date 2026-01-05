<?php

namespace App\Http\Controllers;

use App\Models\Cuisine;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CuisineController extends Controller
{
public function index()
{
    $cuisines = Cuisine::orderBy('name')->get();
    return view('cuisines.index', compact('cuisines'));
}


    public function create()
    {
        return view('cuisines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80', 'unique:cuisines,name'],
        ]);

        $slug = Str::slug($validated['name']);

        // ensure unique slug
        $base = $slug;
        $i = 2;
        while (Cuisine::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        Cuisine::create([
            'name' => $validated['name'],
            'slug' => $slug,
        ]);

        return redirect()->route('cuisines.index')->with('success', 'Cuisine created successfully.');
    }

    public function edit(Cuisine $cuisine)
    {
        return view('cuisines.edit', compact('cuisine'));
    }

    public function update(Request $request, Cuisine $cuisine)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80', 'unique:cuisines,name,'.$cuisine->id],
        ]);

        $slug = Str::slug($validated['name']);

        $base = $slug;
        $i = 2;
        while (Cuisine::where('slug', $slug)->where('id', '!=', $cuisine->id)->exists()) {
            $slug = $base.'-'.$i++;
        }

        $cuisine->update([
            'name' => $validated['name'],
            'slug' => $slug,
        ]);

        return redirect()->route('cuisines.index')->with('success', 'Cuisine updated successfully.');
    }

    public function destroy(Cuisine $cuisine)
    {
        $cuisine->delete();
        return redirect()->route('cuisines.index')->with('success', 'Cuisine deleted successfully.');
    }

    // optional: show page not needed now
    public function show(Cuisine $cuisine)
    {
        return redirect()->route('cuisines.edit', $cuisine);
    }
}
