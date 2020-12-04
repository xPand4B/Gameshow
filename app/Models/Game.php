<?php

namespace App\Models;

use App\Traits\HasRandomStringId;
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
 * @method static userIsGamemaster($user)
 */
class Game extends Model
{
    use HasFactory, HasRandomStringId;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'gamemaster',
        'player_count',
        'correct_points',
        'points_if_wrong_answer',
        'wrong_points',
        'available_joker',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'available_joker' => 'array'
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {

    }
}
