<?php

namespace App\Models;

use App\Models\Traits\HasRandomStringId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 * @method static where(array $array)
 * @method static first()
 * @method static firstOrFail(int $id)
 * @method static firstOrNew(array $condition, array $data)
 * @method static firstOrCreate(array $condition, array $data)
 * @method static updateOrCreate(array $condition, array $data)
 * @method static paginate(int $int)
 * @method static inRandomOrder()
 *
 * @property string id
 * @property int user_id
 * @property int player_count
 * @property int correct_points
 * @property int points_if_wrong_answer
 * @property int wrong_points
 * @property array available_joker
 * @property bool finished
 * @property bool started
 *
 * @property User $user
 */
class Game extends Model
{
    use HasFactory;
    use HasRandomStringId;

    protected $fillable = [
        'user_id',
        'player_count',
        'correct_points',
        'points_if_wrong_answer',
        'wrong_points',
        'available_joker',
        'finished',
        'started',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'player_count' => 'integer',
        'correct_points' => 'integer',
        'points_if_wrong_answer' => 'bool',
        'wrong_points' => 'integer',
        'available_joker' => 'array',
        'finished' => 'bool',
        'started' => 'bool',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
