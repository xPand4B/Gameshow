<?php

namespace App\Http\Controllers\Api;

use App\Helper\AuthHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthApiController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        return AuthHelper::login(
            $request,
            $request->get('username')
        );
    }

    public function me(Request $request): JsonResponse
    {
        return AuthHelper::getAuthResponse();
    }
}
