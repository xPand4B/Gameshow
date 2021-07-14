<?php

namespace Tests\Http\Controllers\Api;

use App\Http\Resources\Question\QuestionResource;
use App\Models\Game;
use App\Models\Question;
use Illuminate\Http\Request;
use Tests\TestCase;

class QuestionApiControllerTest extends TestCase
{
    use ApiControllerTrait;

    private const INDEX_ROUTE   = 'api.v1.game.questions.index';
    private const ADD_ROUTE     = 'api.v1.game.questions.add';
    private const SHOW_ROUTE    = 'api.v1.game.questions.show';
    private const UPDATE_ROUTE  = 'api.v1.game.questions.update';
    private const DESTROY_ROUTE = 'api.v1.game.questions.destroy';

    /** @test */
    public function test_question_api_controller_can_get_all(): void
    {
        $game = $this->createGame()[0];
        $question = $game->questions[0];

        $response = $this->actingAsUser()
            ->json('GET', route(self::INDEX_ROUTE, [
                'gameId' => $game->id
            ]))
            ->assertStatus(200);
        $response = json_decode($response->getContent(), true);

        self::assertArrayHasKey('created_at', $response['data']['attributes'][0]['attributes']);
        self::assertArrayHasKey('updated_at', $response['data']['attributes'][0]['attributes']);

        $response['data']['attributes'][0]['attributes']['created_at'] = null;
        $response['data']['attributes'][0]['attributes']['updated_at'] = null;

        $timestamp = $response['data']['attributes'][0]['attributes']['answers'][0]['created_at'];

        self::assertSame([
            'data' => [
                'attributes' => [
                    [
                        'type' => 'question',
                        'id' => $question->id,
                        'attributes' => [
                            'question' => '',
                            'answers' => [
                                ['id' => 1, 'answer' => null, 'context' => null, 'isCorrect' => false, 'created_at' => $timestamp, 'updated_at' => $timestamp],
                                ['id' => 2, 'answer' => null, 'context' => null, 'isCorrect' => false, 'created_at' => $timestamp, 'updated_at' => $timestamp],
                                ['id' => 3, 'answer' => null, 'context' => null, 'isCorrect' => false, 'created_at' => $timestamp, 'updated_at' => $timestamp],
                                ['id' => 4, 'answer' => null, 'context' => null, 'isCorrect' => false, 'created_at' => $timestamp, 'updated_at' => $timestamp],
                            ],
                            'created_at' => null,
                            'updated_at' => null,
                        ]
                    ]
                ]
            ]
        ], $response);
    }

    /** @test */
    public function test_question_api_controller_can_add(): void
    {
        $game = $this->createGame()[0];
        $game->questions[0]->update([
            'question' => 'Sample Question'
        ]);

        $response = $this->actingAsUser()
            ->json('GET', route(self::ADD_ROUTE, [
                'gameId' => $game->id
            ]))
            ->assertStatus(201);

        $game = Game::first();

        self::assertSame(2, $game->questions->count());

        self::assertSame('Sample Question', $game->questions[0]->question);
        self::assertSame('', $game->questions[1]->question);

        self::assertSame([
            'data' => (new QuestionResource($game->questions[1]))->toArray(new Request())
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function test_question_api_controller_can_show(): void
    {
        $game = $this->createGame()[0];

        $response = $this->actingAsUser()
            ->json('GET', route(self::SHOW_ROUTE, [
                'gameId' => $game->id,
                'questionId' => $game->questions[0]->id
            ]))
            ->assertStatus(200);

        self::assertSame('', $response->getContent());
    }

    /** @test */
    public function test_question_api_controller_can_update_question(): void
    {
        $game = $this->createGame()[0];

        $payload = [
            'name' => 'question',
            'value' => 'Sample Question'
        ];

        $response = $this->actingAsUser()
            ->json('PATCH', route(self::UPDATE_ROUTE, [
                'gameId' => $game->id,
                'questionId' => $game->questions[0]->id
            ]), $payload)
            ->assertStatus(200);

        self::assertSame('Sample Question', Game::first()->questions[0]->question);
        self::assertSame([
            'message' => [
                'status' => 200,
                'text' => 'Entry has been successfully updated!'
            ]
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function test_question_api_controller_can_update_answer_option(): void
    {
        $this->withoutExceptionHandling();
        $game = $this->createGame()[0];

        $payloads = [
            ['answerId' => 1, 'name' => 'answer', 'value' => 'Sample Answer'],
            ['answerId' => 1, 'name' => 'context', 'value' => 'Sample Context'],
            ['answerId' => 1, 'name' => 'isCorrect', 'value' => true],
        ];

        foreach ($payloads as $payload) {
            $response = $this->actingAsUser()
                ->json('PATCH', route(self::UPDATE_ROUTE, [
                    'gameId' => $game->id,
                    'questionId' => $game->questions[0]->id
                ]), $payload)
                ->assertStatus(200);

            self::assertSame($payload['value'], Game::first()->questions[0]->answers[0][$payload['name']]);

            self::assertSame([
                'message' => [
                    'status' => 200,
                    'text' => 'Entry has been successfully updated!'
                ]
            ], json_decode($response->getContent(), true));
        }
    }

    /** @test */
    public function test_question_api_controller_can_destroy(): void
    {
        $game = $this->createGame()[0];

        $response = $this->actingAsUser()
            ->json('DELETE', route(self::DESTROY_ROUTE, [
                'gameId' => $game->id,
                'questionId' => $game->questions[0]->id
            ]))
            ->assertStatus(200);

        self::assertSame(0, Game::first()->questions->count());
        self::assertSame([
            'message' => [
                'status' => 200,
                'text' => 'Entry has been successfully deleted!'
            ]
        ], json_decode($response->getContent(), true));
    }
}
