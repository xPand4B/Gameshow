<?php

namespace App\Models;

use App\Models\Traits\HasRandomStringId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static findOrFail($id)
 * @method static create(array $all)
 * @method static first()
 * @method static paginate(int $int)
 * @method static where(array[] $array)
 * @method static firstOrFail()
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
        'available_joker' => 'array'
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
