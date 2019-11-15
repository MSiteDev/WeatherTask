<?php

use App\Http\Controllers\PlaceController;
use Illuminate\Support\Facades\Route;

Route::prefix('places')->group(function() {

    Route::get('', [PlaceController::class, 'index']);

    Route::get('search', [PlaceController::class, 'search']);

    Route::get('{place}', [PlaceController::class, 'show'])->where('place', '[0-9]+');

    Route::get('find', [PlaceController::class, 'create']);

});
