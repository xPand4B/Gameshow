<?php

namespace Tests\Actions\Questions;

use App\Actions\Questions\GetCurrentQuestion;
use App\Models\Game;
use App\Models\Question;
use App\Models\User;
use Tests\Actions\ActionsTrait;
use Tests\TestCase;

/**
 * @group Actions
 */
class GetCurrentQuestionTest extends TestCase
{
    use ActionsTrait;

    /** @test */
    public function test_it_can_get_current_question(): void
    {
        $user = User::factory()->create();
        $game = Game::factory()->create(['user_id' => $user->id]);

        $questionId = 'aaaabbbbcccc';

        $expected = Question::factory()->create([
            'id' => $questionId,
            'game_id' => $game->id
        ]);
        $actual = GetCurrentQuestion::run($game->id, $questionId);

        self::assertEquals($expected->fresh(), $actual);
    }
}
