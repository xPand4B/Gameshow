<?php

namespace Tests\Actions\Answers;

use App\Actions\Answers\CreateNewAnswer;
use Tests\Actions\ActionsTrait;
use Tests\TestCase;

/**
 * @group Actions
 */
class CreateNewAnswerTest extends TestCase
{
    use ActionsTrait;

    /** @test */
    public function test_if_can_create_new_answer(): void
    {
        $question = $this->createQuestion();

        CreateNewAnswer::run($question);
        $answers = $question->answers;
        self::assertCount(5, $answers);

        $actual = end($answers);
        self::assertArrayHasKey('created_at', $actual);
        self::assertArrayHasKey('updated_at', $actual);
        unset($actual['created_at']);
        unset($actual['updated_at']);

        self::assertSame([
            'id' => 5,
            'answer' => null,
            'context' => null,
            'isCorrect' => false,
        ], $actual);
    }
}
