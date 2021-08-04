<?php

namespace App\Helper;

use App\Actions\Auth\LoginUser;
use App\Actions\Auth\LogoutUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthHelper extends Controller
{
    public const AUTH_TOKEN_NAME = 'auth_token';

    public static function login(Request $request, string $username): JsonResponse
    {
        LogoutUser::run();

        $token = $request->cookie(self::AUTH_TOKEN_NAME);

        LoginUser::run($request, $username, $token);

        return self::getAuthResponse()->withCookie(
            cookie()->forever(self::AUTH_TOKEN_NAME, $token)
        );
    }

    public static function getAuthResponse(): JsonResponse
    {
        return response()->json([
            'success' => !!Auth::user(),
            'id' => Auth::user()->id ?? null,
            'playerName' => Auth::user()->username ?? null,
        ]);
    }
}
