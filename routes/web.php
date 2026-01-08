<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CuisineController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RestaurantImageController;
use App\Http\Controllers\MapController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('cuisines', CuisineController::class);

Route::resource('restaurants', RestaurantController::class);

Route::get('/', fn () => redirect()->route('restaurants.index'));

Route::post('restaurants/{restaurant}/images', [RestaurantImageController::class, 'store'])
    ->name('restaurants.images.store');

Route::delete('restaurants/{restaurant}/images/{image}', [RestaurantImageController::class, 'destroy'])
    ->name('restaurants.images.destroy');

Route::get('/map', [MapController::class, 'index'])->name('map.index');