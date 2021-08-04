<?php

namespace Tests\Actions\Answers;

use App\Actions\Answers\DeleteAnswer;
use App\Http\Resources\Error\ErrorResource;
use Illuminate\Http\JsonResponse;
use Tests\Actions\ActionsTrait;
use Tests\TestCase;

/**
 * @group Actions
 */
class DeleteAnswerTest extends TestCase
{
    use ActionsTrait;

    /** @test */
    public function test_it_can_delete_answer(): void
    {
        $question = $this->createQuestion();

        $response = DeleteAnswer::run($question, 1);
        self::assertNull($response);
        self::assertCount(3, $question->answers);
        self::assertSame(2, $question->answers[0]['id']);
        self::assertSame(3, $question->answers[1]['id']);
        self::assertSame(4, $question->answers[2]['id']);
    }

    /** @test */
    public function test_it_can_throw_error_if_only_two_answers_exist(): void
    {
        $question = $this->createQuestion();

        $question->answers = [
            $question->answers[0],
            $question->answers[1],
        ];

        $actual = DeleteAnswer::run($question, 1);
        $expected = $this->generateErrorResource('At least two answer options are necessary.');
        self::assertEquals($expected, $actual);
    }

    /** @test */
    public function test_it_can_throw_error_if_answer_id_is_invalid(): void
    {
        $question = $this->createQuestion();

        $actual = DeleteAnswer::run($question, 5);
        $expected = $this->generateErrorResource("Answer with id '5' does not exist.");
        self::assertEquals($expected, $actual);
    }

    private function generateErrorResource(string $message): JsonResponse
    {
        return (new ErrorResource())
            ->setSource('/database/models/answer')
            ->setDetail($message)
            ->setStatusCode(403)
            ->getError();
    }
}
