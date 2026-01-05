<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CuisineController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('cuisines', CuisineController::class);
