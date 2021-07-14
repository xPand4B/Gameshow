<?php

namespace App\Observers;

use App\Models\Game;
use App\Models\Question;

class GameObserver
{
    public function created(Game $game): void
    {
        Question::create(
            Question::getAnswerScaffolding($game->id)
        );
    }

    public function updated(Game $game): void
    {
        //
    }

    public function deleted(Game $game): void
    {
        //
    }

    public function restored(Game $game): void
    {
        //
    }

    public function forceDeleted(Game $game): void
    {
        //
    }
}
