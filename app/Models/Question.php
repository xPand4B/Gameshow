<?php

namespace App\Models;

use App\Models\Traits\HasAnswers;
use App\Models\Traits\HasRandomStringId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 * @method static where(array $array)
 * @method static first()
 * @method static firstOrFail()
 * @method static firstOrNew(array $condition, array $data)
 * @method static firstOrCreate(array $condition, array $data)
 * @method static updateOrCreate(array $condition, array $data)
 * @method static paginate(int $int)
 * @method static inRandomOrder()
 *
 * @property string id
 * @property string game_id
 * @property string question
 * @property array answers
 */
class Question extends Model
{
    use HasFactory;
    use HasRandomStringId;
    use HasAnswers;

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
}
