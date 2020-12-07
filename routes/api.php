<?php

use App\Http\Controllers\Api\GameApiController;
use App\Http\Controllers\Api\AuthApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function() {
    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    */
    Route::prefix('auth')->group(function() {
        Route::post(
            'login', [AuthApiController::class, 'login']
        )->name('api.v1.auth.login');

        Route::get(
            'me', [AuthApiController::class, 'me']
        )->name('api.v1.auth.me');
    });

    /*
    |--------------------------------------------------------------------------
    | Game
    |--------------------------------------------------------------------------
    */
    Route::prefix('game')->group(function() {
        Route::post(
            '', [GameApiController::class, 'store']
        )->name('api.v1.game.store');

        Route::get(
            '/{id}', [GameApiController::class, 'show']
        )->name('api.v1.game.show');

        Route::get(
            '/{id}/exists', [GameApiController::class, 'exists']
        )->name('api.v1.game.exists');

        Route::patch(
            '/{id}', [GameApiController::class, 'update']
        )->name('api.v1.game.update');
    });
});
