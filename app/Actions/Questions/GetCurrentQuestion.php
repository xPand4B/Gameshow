<?php

namespace App\Actions\Questions;

use App\Models\Question;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCurrentQuestion
{
    use AsAction;

    public function handle(string $gameId, string $questionId): ?Question
    {
        return Question::where([
            'id' => $questionId,
            'game_id' => $gameId,
        ])->first();
    }
}
