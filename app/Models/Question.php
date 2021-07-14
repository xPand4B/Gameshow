<?php

namespace App\Models;

use App\Models\Traits\HasRandomStringId;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $data)
 * @method static findOrFail($id)
 * @method static where(array $array)
 * @method static first()
 * @method static firstOrFail()
 */
class Question extends Model
{
    use HasFactory;
    use HasRandomStringId;

    protected $fillable = [
        'game_id',
        'question',
        'answers',
    ];

    protected $casts = [
        'answers' => 'array'
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

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
