<?php

namespace Tests\Http\Resources\Question;

use App\Models\Game;
use App\Models\Question;
use Tests\Http\Resources\Game\GameResourceTrait;
use Tests\TestCase;

class QuestionCollectionTest extends TestCase
{
    use GameResourceTrait, QuestionResourceTrait;

    /** @test */
    public function test_question_resource_collection_has_correct_format(): void
    {
        self::assertSame(0, Game::all()->count());
        self::assertSame(0, Question::all()->count());

        $game = $this->createGame()[0];

        self::assertSame(1, Game::all()->count());
        self::assertSame(1, Question::all()->count());

        Question::factory()->count(3)->create();
        self::assertSame(4, Question::all()->count());

        $question = $game->questions[0];
        $resource = $this->getQuestionCollection();
        $resource = json_decode(json_encode($resource), true);

        self::assertIsArray($resource);
        self::assertArrayHasKey('attributes', $resource);
        self::assertCount(4, $resource['attributes']);
    }
}
