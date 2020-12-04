<?php

use App\Http\Controllers\Api\GameApiController;
use App\Http\Controllers\Api\LobbyApiController;
use App\Http\Controllers\Api\LoginApiController;
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
    Route::prefix('login')->group(function() {
        Route::post(
            '', [LoginApiController::class, 'login']
        )->name('api.v1.auth.login');
    });

    /*
    |--------------------------------------------------------------------------
    | Game
    |--------------------------------------------------------------------------
    */
    Route::prefix('game')->group(function() {
        Route::get(
            '', [GameApiController::class, 'index']
        )->name('api.v1.game.index');

        Route::post(
            '', [GameApiController::class, 'store']
        )->name('api.v1.game.store');

        Route::get(
            '/{id}', [GameApiController::class, 'show']
        )->name('api.v1.game.show');

        Route::patch(
            '/{id}', [GameApiController::class, 'update']
        )->name('api.v1.game.update');
    });

    /*
    |--------------------------------------------------------------------------
    | Lobby
    |--------------------------------------------------------------------------
    */
    Route::prefix('lobby')->group(function() {
        Route::post(
            '{game}/join', [LobbyApiController::class, 'join']
        )->name('api.v1.lobby.join');
    });
});
