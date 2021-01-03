<?php

namespace Tests\Http\Resources\Question;

use App\Http\Resources\Question\QuestionCollection;
use App\Http\Resources\Question\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;

trait QuestionResourceTrait
{
    /**
     * @return array
     */
    public function getQuestionResource(): array
    {
        $request = new Request();
        $question = Question::first();

        return (new QuestionResource($question))->toArray($request);
    }

    /**
     * @return array
     */
    public function getQuestionCollection(): array
    {
        $request = new Request();
        $questions = Question::all();

        return (new QuestionCollection($questions))->toArray($request);
    }
}
