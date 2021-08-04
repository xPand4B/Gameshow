<?php

namespace App\Models\Traits;

use App\Models\Game;
use Carbon\Carbon;

trait HasAnswers
{
    public static function getAnswerScaffolding(string $gameId): array
    {
        Game::findOrFail($gameId);

        return [
            'game_id' => $gameId,
            'question' => '',
            'answers' => [
                self::getAnswerOptionScaffolding(1),
                self::getAnswerOptionScaffolding(2),
                self::getAnswerOptionScaffolding(3),
                self::getAnswerOptionScaffolding(4),
            ]
        ];
    }

    public static function getAnswerOptionScaffolding(int $id): array
    {
        $now = Carbon::now()->toDateTimeString();

        return [
            'id' => $id,
            'answer' => null,
            'context' => null,
            'isCorrect' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }
}
