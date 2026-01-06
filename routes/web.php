<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CuisineController;
use App\Http\Controllers\RestaurantController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('cuisines', CuisineController::class);
Route::resource('restaurants', RestaurantController::class);
Route::get('/', fn () => redirect()->route('restaurants.index'));
