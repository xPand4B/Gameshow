<?php

use App\Http\Controllers\VueController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function() {
    /*
    |--------------------------------------------------------------------------
    | Vue.js
    |--------------------------------------------------------------------------
    */
    Route::get(
        '/{any}', [VueController::class, 'index']
    )->where('any', '.*');
});
