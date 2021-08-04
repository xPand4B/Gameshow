<?php

namespace Tests\Actions\Questions;

use App\Actions\Questions\GetCurrentQuestion;
use App\Actions\Questions\UpdateQuestion;
use App\Models\Game;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Tests\Actions\ActionsTrait;
use Tests\TestCase;

/**
 * @group Actions
 */
class UpdateQuestionTest extends TestCase
{
    use ActionsTrait;

    /** @test */
    public function test_it_can_update_question_question(): void
    {
        $sampleQuestion = 'Why am I here?';

        $question = $this->createQuestion();
        self::assertNotSame($sampleQuestion, $question->question);

        $request = new Request([], [], [
            'name' => 'question',
            'value' => $sampleQuestion
        ]);

        /** @var Question $actual */
        $actual = UpdateQuestion::run($request, $question);

        self::assertSame($sampleQuestion, $actual->question);
    }

    /** @test */
    public function test_it_can_update_question_answers(): void
    {
        $sampleValue = 'Sample Value';

        $question = $this->createQuestion();
        self::assertNotSame($sampleValue, $question->question);
        self::assertNotSame($sampleValue, $question->answers[0]['answer']);
        self::assertNotSame($sampleValue, $question->answers[0]['isCorrect']);

        // Answer field name
        $request = new Request([], [], [
            'name' => 'answer',
            'value' => $sampleValue,
            'answerId' => 1,
        ]);

        /** @var Question $actual */
        $actual = UpdateQuestion::run($request, $question);
        self::assertSame($sampleValue, $actual->answers[0]['answer']);

        // isCorrect field name
        $question->fresh();
        $isCorrect = $question->answers[0]['isCorrect'];
        $request = new Request([], [], [
            'name' => 'isCorrect',
            'value' => !$isCorrect,
            'answerId' => 1,
        ]);

        /** @var Question $actual */
        $actual = UpdateQuestion::run($request, $question);
        self::assertSame($sampleValue, $actual->answers[0]['answer']);
        self::assertSame(!$isCorrect, $actual->answers[0]['isCorrect']);
    }

    /** @test */
    public function test_it_does_nothing_with_invalid_answer_id(): void
    {
        $sampleAnswer = 'Sample Answer';
        $sampleAnswerValue = 'Sample Answer Value';

        $question = $this->createQuestion();
        $request = new Request([], [], [
            'name' => $sampleAnswer,
            'value' => $sampleAnswerValue,
            'answerId' => 1337,
        ]);

        /** @var Question $actual */
        $actual = UpdateQuestion::run($request, $question);

        self::assertSame($question, $actual);
    }

    /** @test */
    public function test_it_does_nothing_with_invalid_answer_field_name(): void
    {
        $question = $this->createQuestion();
        $request = new Request([], [], [
            'name' => 'Something',
            'value' => 'blub',
            'answerId' => 1,
        ]);

        /** @var Question $actual */
        $actual = UpdateQuestion::run($request, $question);

        self::assertSame($question, $actual);
    }
}
