<?php

use App\Http\Controllers\Api\AnswerApiController;
use App\Http\Controllers\Api\GameApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\QuestionApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    */
    Route::prefix('auth')->controller(AuthApiController::class)->group(function() {
        Route::post('login', 'login')->name('api.v1.auth.login');
        Route::get('me','me')->name('api.v1.auth.me');
    });

    /*
    |--------------------------------------------------------------------------
    | Game
    |--------------------------------------------------------------------------
    */
    Route::prefix('game')->controller(GameApiController::class)->group(function() {
        Route::get('/{gameId}/exists', 'exists')->name('api.v1.game.exists');
    });

    /*
    |--------------------------------------------------------------------------
    | Auth protected
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function() {
        /*
        |--------------------------------------------------------------------------
        | Game
        |--------------------------------------------------------------------------
        */
        Route::prefix('game')->controller(GameApiController::class)->group(function() {
            Route::post('/', 'store')->name('api.v1.game.store');
            Route::get('/{gameId}', 'show')->name('api.v1.game.show');
            Route::patch('/{gameId}', 'update')->name('api.v1.game.update');
            Route::delete('/{gameId}', 'destroy')->name('api.v1.game.destroy');
        });

        /*
        |--------------------------------------------------------------------------
        | Question
        |--------------------------------------------------------------------------
        */
        Route::controller(QuestionApiController::class)->group(function() {
            Route::get('/{gameId}/questions', 'index')->name('api.v1.game.questions.index');
            Route::get('/{gameId}/questions/add', 'add')->name('api.v1.game.questions.add');
            Route::get('/{gameId}/questions/{questionId}', 'show')->name('api.v1.game.questions.show');
            Route::patch('/{gameId}/questions/{questionId}', 'update')->name('api.v1.game.questions.update');
            Route::delete('/{gameId}/questions/{questionId}', 'destroy')->name('api.v1.game.questions.destroy');
        });

        /*
        |--------------------------------------------------------------------------
        | Answer
        |--------------------------------------------------------------------------
        */
        Route::controller(AnswerApiController::class)->group(function() {
            Route::get('/{gameId}/questions/{questionId}/add', 'add')->name('api.v1.game.questions.answer.add');
            Route::delete('/{gameId}/questions/{questionId}/{answerId}', 'destroy')->name('api.v1.game.questions.answer.destroy');
        });
    });
});
