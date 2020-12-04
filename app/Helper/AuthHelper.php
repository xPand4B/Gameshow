<?php

namespace App\Helper;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthHelper extends Controller
{
    /**
     * @param string $username
     * @return JsonResponse
     */
    public static function login(string $username): JsonResponse
    {
        if (auth()->user()) {
            Auth::logout();
        }

        $user = User::where(
            'username', $username
        )->get();

        if ($user->count() === 0) {
            $user = User::create([
                'username' => $username
            ]);
        }

        Auth::login($user->first());

        return response()->json([
            'success' => !!auth()->user()
        ]);
    }
}
