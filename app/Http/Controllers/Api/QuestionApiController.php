<?php

namespace App\Http\Controllers\Api;

use App\Helper\MessageResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Question\UpdateQuestionRequest;
use App\Http\Resources\Question\QuestionCollection;
use App\Http\Resources\Question\QuestionResource;
use App\Models\Game;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionApiController extends Controller
{
    public function index($gameId): QuestionCollection
    {
        return new QuestionCollection(
            Game::findOrFail($gameId)->questions()->orderBy('created_at')->get()
        );
    }

    public function add($gameId): QuestionResource
    {
        $question = Question::create(
            Question::getAnswerScaffolding($gameId)
        );

        return new QuestionResource($question);
    }

    public function show(Request $request, $gameId, $questionId)
    {
        // nth
    }

    public function update(UpdateQuestionRequest $request, $gameId, $questionId): JsonResponse
    {
        $request->validated();

        $question = Question::where([
            'id' => $questionId,
            'game_id' => $gameId
        ])->first();

        $fieldName  = $request->get('name');
        $fieldValue = $request->get('value');

        if ($fieldName === 'question') {
            $question->update([
                'question' => $fieldValue
            ]);

            return MessageResponse::json('Entry has been successfully updated!');
        }

        $answerId = $request->get('answerId');
        $answers  = $question->answers;

        foreach ($answers as $index => $answer) {
            if ($answer['id'] === $answerId) {
                $answers[$index][$fieldName] = $fieldValue;
                $answers[$index]['updated_at'] = Carbon::now()->toDateTimeString();
                break;
            }
        }

        $question->update([
            'answers' => array_values($answers)
        ]);

        return MessageResponse::json('Entry has been successfully updated!');
    }

    public function destroy($gameId, $questionId): JsonResponse
    {
        Question::where([
            'id' => $questionId,
            'game_id' => $gameId
        ])->delete();

        return MessageResponse::json('Entry has been successfully deleted!');
    }
}
