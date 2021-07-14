<?php

namespace Tests\Http\Requests\Question;

use App\Http\Requests\Question\UpdateQuestionRequest;
use Tests\TestCase;

class UpdateQuestionRequestTest extends TestCase
{
    private function getQuestionRequest(): UpdateQuestionRequest
    {
        return new UpdateQuestionRequest();
    }

    /** @test */
    public function test_question_request_authorization(): void
    {
        self::assertTrue($this->getQuestionRequest()->authorize());
    }

    /** @test */
    public function test_question_request_rules(): void
    {
        self::assertSame([
            'name'      => 'bail|required|alpha_num',
            'value'     => 'bail|required',
            'answerId'  => 'bail|numeric',
        ], $this->getQuestionRequest()->rules());
    }
}
