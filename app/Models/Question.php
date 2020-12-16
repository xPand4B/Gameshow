<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $data)
 * @method static findOrFail($id)
 */
class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'game_id',
        'question',
        'answers',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'answers' => 'array'
    ];

    /**
     * @return BelongsTo
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * @param Game $game
     * @return array
     */
    public static function getAnswerScaffolding(Game $game): array
    {
        return [
            'game_id' => $game->id,
            'question' => null,
            'answers' => [
                self::getAnswerOptionScaffolding(),
                self::getAnswerOptionScaffolding(),
                self::getAnswerOptionScaffolding(),
                self::getAnswerOptionScaffolding(),
            ]
        ];
    }

    /**
     * @return array
     */
    private static function getAnswerOptionScaffolding(): array
    {
        return ['answer' => null, 'context' => null, 'isCorrect' => false];
    }
}
