<?php

namespace App\Providers;

use App\Models\Game;
use App\Models\Question;
use Illuminate\Support\ServiceProvider;

class GameServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Game::created(function($game) {
            Question::create(
                Question::getAnswerScaffolding($game)
            );
        });
    }
}
