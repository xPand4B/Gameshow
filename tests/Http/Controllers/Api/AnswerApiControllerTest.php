<?php

namespace Tests\Http\Controllers\Api;

use App\Http\Resources\Error\ErrorResource;
use App\Http\Resources\Question\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;
use Tests\TestCase;

class AnswerApiControllerTest extends TestCase
{
    use ApiControllerTrait;

    private const ADD_ROUTE = 'api.v1.game.questions.answer.add';
    private const DELETE_ROUTE = 'api.v1.game.questions.answer.destroy';

    /** @test */
    public function test_answer_api_controller_can_add_answers(): void
    {
        $game = $this->createGame()[0];
        $question = Question::firstOrFail();

        self::assertSame(1, Question::all()->count());
        self::assertCount(4, $question->answers);

        $response = $this->actingAsUser()
            ->json('GET', route(self::ADD_ROUTE, [
                'gameId' => $game->id,
                'questionId' => $question->id
            ]))
            ->assertStatus(200);

        $question = Question::firstOrFail();
        self::assertCount(5, $question->answers);
        self::assertSame([
            'data' => (new QuestionResource($question))->toArray(new Request())
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function test_answer_api_controller_can_delete_answers(): void
    {
        $game = $this->createGame()[0];
        $question = Question::firstOrFail();

        self::assertSame(1, Question::all()->count());
        self::assertCount(4, $question->answers);

        $response = $this->actingAsUser()
            ->json('DELETE', route(self::DELETE_ROUTE, [
                'gameId' => $game->id,
                'questionId' => $question->id,
                'answerId' => 1
            ]))
            ->assertStatus(200);

        $question = Question::firstOrFail();
        self::assertCount(3, $question->answers);
        self::assertSame([
            'data' => (new QuestionResource($question))->toArray(new Request())
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function test_answer_api_controller_wont_delete_answers_if_only_two_remaining(): void
    {
        $this->withoutExceptionHandling();
        $game = $this->createGame()[0];
        $question = Question::firstOrFail();

        self::assertSame(1, Question::all()->count());
        self::assertCount(4, $question->answers);

        $question->update([
            'answers' => [
                ['id' => 1, 'answer' => null, 'context' => null, 'isCorrect' => false],
                ['id' => 2, 'answer' => null, 'context' => null, 'isCorrect' => false],
            ]
        ]);

        $response = $this->actingAsUser()
            ->json('DELETE', route(self::DELETE_ROUTE, [
                'gameId' => $game->id,
                'questionId' => $question->id,
                'answerId' => 1
            ]))
            ->assertStatus(403);

        $expectedError = (new ErrorResource())
            ->setSource('/database/models/answer')
            ->setDetail("At least two answer options are necessary.")
            ->setStatusCode(403)
            ->getError();

        self::assertSame($expectedError->getContent(), $response->getContent());
    }
}
