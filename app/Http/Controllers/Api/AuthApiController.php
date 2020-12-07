<?php

namespace App\Http\Controllers\Api;

use App\Helper\AuthHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthApiController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $request->validated();

        return AuthHelper::login(
            $request->get('username')
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        return AuthHelper::getAuthResponse();
    }
}
