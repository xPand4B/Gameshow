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
        Route::get(
            '/{gameId}/exists', [GameApiController::class, 'exists']
        )->name('api.v1.game.exists');
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
        Route::prefix('game')->group(function() {
            Route::post(
                '', [GameApiController::class, 'store']
            )->name('api.v1.game.store');

            Route::get(
                '/{gameId}', [GameApiController::class, 'show']
            )->name('api.v1.game.show');

            Route::patch(
                '/{gameId}', [GameApiController::class, 'update']
            )->name('api.v1.game.update');

            Route::delete(
                '/{gameId}', [GameApiController::class, 'destroy']
            )->name('api.v1.game.destroy');

            /*
            |--------------------------------------------------------------------------
            | Question
            |--------------------------------------------------------------------------
            */
            Route::get(
                '/{gameId}/questions', [QuestionApiController::class, 'index']
            )->name('api.v1.game.questions.index');

            Route::get(
                '/{gameId}/questions/add', [QuestionApiController::class, 'add']
            )->name('api.v1.game.questions.add');

            Route::get(
                '/{gameId}/questions/{questionId}', [QuestionApiController::class, 'show']
            )->name('api.v1.game.questions.show');

            Route::patch(
                '/{gameId}/questions/{questionId}', [QuestionApiController::class, 'update']
            )->name('api.v1.game.questions.update');

            Route::delete(
                '/{gameId}/questions/{questionId}', [QuestionApiController::class, 'destroy']
            )->name('api.v1.game.questions.destroy');

            /*
            |--------------------------------------------------------------------------
            | Answer
            |--------------------------------------------------------------------------
            */
            Route::get(
                '/{gameId}/questions/{questionId}/add', [AnswerApiController::class, 'add']
            )->name('api.v1.game.questions.answer.add');

            Route::delete(
                '/{gameId}/questions/{questionId}/{answerId}', [AnswerApiController::class, 'destroy']
            )->name('api.v1.game.questions.answer.destroy');
        });
    });
});
