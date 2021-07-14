<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $data)
 * @method static first()
 * @method static findOrFail($id)
 * @method static paginate(int $int)
 */
class Joker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
