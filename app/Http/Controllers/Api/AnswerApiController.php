<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Error\ErrorResource;
use App\Http\Resources\Question\QuestionResource;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnswerApiController extends Controller
{
    public function add(Request $request, string $gameId, string $questionId): QuestionResource
    {
        $question = Question::where([
            'id' => $questionId,
            'game_id' => $gameId
        ])->first();

        $answers = $question->answers;

        $latestId = 1;
        foreach ($answers as $answer) {
            if ($answer['id'] > $latestId) {
                $latestId = $answer['id'];
            }
        }

        $answers[$latestId + 1] = Question::getAnswerOptionScaffolding($latestId + 1);

        $question->update([
            'answers' => array_values($answers)
        ]);

        return new QuestionResource($question);
    }

    public function destroy(Request $request, string $gameId, string $questionId, int $answerId)
    {
        $question = Question::where([
            'id' => $questionId,
            'game_id' => $gameId
        ])->first();

        $answers = $question->answers;

        if (count($answers) === 2) {
            return (new ErrorResource())
                ->setSource('/database/models/answer')
                ->setDetail("At least two answer options are necessary.")
                ->setStatusCode(403)
                ->getError();
        }

        foreach ($answers as $index => $answer) {
            if ($answer['id'] === $answerId) {
                array_splice($answers, $index, 1);
                break;
            }
        }

        $question->update([
            'answers' => array_values($answers)
        ]);

        return new QuestionResource($question);
    }
}
