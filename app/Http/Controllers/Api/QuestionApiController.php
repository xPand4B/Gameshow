<?php

namespace App\Http\Controllers\Api;

use App\Actions\Questions\GetCurrentQuestion;
use App\Actions\Questions\UpdateQuestion;
use App\Helper\MessageResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Question\UpdateQuestionRequest;
use App\Http\Resources\Question\QuestionCollection;
use App\Http\Resources\Question\QuestionResource;
use App\Models\Game;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionApiController extends Controller
{
    public function index(Request $request, string $gameId): QuestionCollection
    {
        return new QuestionCollection(
            Game::findOrFail($gameId)
                ->questions()
                ->orderBy('created_at')
                ->get()
        );
    }

    public function add(Request $request, string $gameId): QuestionResource
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

    public function update(UpdateQuestionRequest $request, string $gameId, string $questionId): JsonResponse
    {
        $question = GetCurrentQuestion::run($gameId, $questionId);

        UpdateQuestion::run($request, $question);

        return MessageResponse::json('Entry has been successfully updated!');
    }

    public function destroy(Request $request, string $gameId, string $questionId): JsonResponse
    {
        GetCurrentQuestion::run($gameId, $questionId)->delete();

        return MessageResponse::json('Entry has been successfully deleted!');
    }
}
