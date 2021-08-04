<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
 * @property string username
 * @property string auth_token
 * @property mixed last_login_ip
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
