<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;

class LoginUser
{
    use AsAction;

    public function handle(Request $request, string $username, ?string $token)
    {
        $user = User::updateOrCreate([
            'username' => $username,
            'auth_token' => $token,
        ], [
            'username'      => $username,
            'auth_token'    => $token ?? Str::random(24),
            'last_login_ip' => $request->getClientIp(),
            'last_login_at' => now(),
        ]);

        Auth::login($user);
    }
}
