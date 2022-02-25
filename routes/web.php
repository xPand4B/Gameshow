<?php

use App\Http\Controllers\VueController;
use Illuminate\Support\Facades\Route;

Route::controller(VueController::class)->group(function() {
    Route::get('/{any}', 'index')->where('any', '.*');
});
