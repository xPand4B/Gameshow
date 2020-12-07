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
        if (Auth::check()) {
            Auth::logout();
        }

        $user = User::where(
            'username', '=', $username
        )->get();

        if ($user->count() === 0) {
            $user = User::create([
                'username' => $username
            ]);
        } else {
            $user = $user[0];
        }

        Auth::login($user);

        return self::getAuthResponse();
    }

    /**
     * @return JsonResponse
     */
    public static function getAuthResponse(): JsonResponse
    {
        return response()->json([
            'success' => !!Auth::user(),
            'playerName' => Auth::user()->username ?? null
        ]);
    }
}
