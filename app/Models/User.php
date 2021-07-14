<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static create(array $array)
 * @method static inRandomOrder()
 * @method static where(array $array)
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'username',
        'auth_token',
        'last_login_ip',
        'last_login_at',
    ];

    protected $hidden = [
        'remember_token',
        'auth_token',
    ];

    public function game(): HasOne
    {
        return $this->hasOne(Game::class);
    }
}
