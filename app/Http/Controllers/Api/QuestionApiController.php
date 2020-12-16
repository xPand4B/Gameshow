<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Error\ErrorResource;
use App\Http\Resources\Question\QuestionCollection;
use App\Http\Resources\Question\QuestionResource;
use App\Models\Game;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionApiController extends Controller
{
    /**
     * @param Request $request
     * @param $gameId
     * @return QuestionCollection
     */
    public function index(Request $request, $gameId): QuestionCollection
    {
        $game = Game::findOrFail($gameId);

        return new QuestionCollection($game->questions);
    }

    /**
     * @param Request $request
     * @param $gameId
     * @return QuestionCollection
     */
    public function store(Request $request, $gameId): QuestionCollection
    {
        $game = Game::findOrFail($gameId);

        Question::create(
            Question::getAnswerScaffolding($game)
        );

        return new QuestionCollection($game->questions);
    }

    /**
     * @param Request $request
     * @param $gameId
     * @param $questionId
     */
    public function show(Request $request, $gameId, $questionId)
    {

        $question = Game::findOrFail($gameId)
            ->with('questions');

        dd($question);
//        return new QuestionCollection($game->questions);
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy(Request $request, $gameId, $questionId)
    {

    }
}
