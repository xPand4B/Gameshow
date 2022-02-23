<?php

namespace App\Http\Controllers\Api;

use App\Actions\Answers\CreateNewAnswer;
use App\Actions\Answers\DeleteAnswer;
use App\Actions\Questions\GetCurrentQuestion;
use App\Http\Controllers\Controller;
use App\Http\Resources\Question\QuestionResource;

class AnswerApiController extends Controller
{
    public function add(string $gameId, string $questionId): QuestionResource
    {
        $question = CreateNewAnswer::run(
            GetCurrentQuestion::run($gameId, $questionId)
        );

        return new QuestionResource($question);
    }

    public function destroy(string $gameId, string $questionId, int $answerId)
    {
        $question = GetCurrentQuestion::run($gameId, $questionId);

        if ($errorResponse = DeleteAnswer::run($question, $answerId)) {
            return $errorResponse;
        }

        return new QuestionResource($question);
    }
}
