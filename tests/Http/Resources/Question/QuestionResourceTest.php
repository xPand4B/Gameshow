<?php

namespace Tests\Http\Resources\Question;

use App\Models\Game;
use App\Models\Question;
use Tests\Http\Resources\Game\GameResourceTrait;
use Tests\TestCase;

/**
 * @group Resources
 */
class QuestionResourceTest extends TestCase
{
    use GameResourceTrait;
    use QuestionResourceTrait;

    /** @test */
    public function test_question_resource_has_correct_format(): void
    {
        self::assertSame(0, Game::all()->count());
        self::assertSame(0, Question::all()->count());

        $game = $this->createGame()[0];

        self::assertSame(1, Game::all()->count());
        self::assertSame(1, Question::all()->count());

        $question = $game->questions[0];
        $resource = $this->getQuestionResource();

        self::assertIsArray($resource);
        self::assertSame('question', $resource['type']);
        self::assertSame($question->id, $resource['id']);
        self::assertArrayHasKey('created_at', $resource['attributes']);
        self::assertArrayHasKey('updated_at', $resource['attributes']);

        $resource['attributes']['created_at'] = null;
        $resource['attributes']['updated_at'] = null;
        $timestamp = $resource['attributes']['answers'][0]['created_at'];

        self::assertSame([
            'question' => '',
            'answers' => [
                [ 'id' => 1, 'answer' => null, 'context' => null, 'isCorrect' => false, 'created_at' => $timestamp, 'updated_at' => $timestamp ],
                [ 'id' => 2, 'answer' => null, 'context' => null, 'isCorrect' => false, 'created_at' => $timestamp, 'updated_at' => $timestamp ],
                [ 'id' => 3, 'answer' => null, 'context' => null, 'isCorrect' => false, 'created_at' => $timestamp, 'updated_at' => $timestamp ],
                [ 'id' => 4, 'answer' => null, 'context' => null, 'isCorrect' => false, 'created_at' => $timestamp, 'updated_at' => $timestamp ],
            ],
            'created_at' => null,
            'updated_at' => null,
        ], $resource['attributes']);
    }
}
