<?php

namespace Tests\Actions;

use App\Models\Game;
use App\Models\Question;
use App\Models\User;

trait ActionsTrait
{
    public function createQuestion(): Question
    {
        $this->withoutEvents();
        /** @var Question $question */
        $question = Question::factory()->create();

        self::assertCount(1, User::all());
        self::assertCount(1, Game::all());
        self::assertCount(2, Question::all());
        self::assertCount(4, $question->answers);

        return $question;
    }
}
