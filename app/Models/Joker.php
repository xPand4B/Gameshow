<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property int id
 * @property string name
 */
class Joker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
