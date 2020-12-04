<?php

namespace App\Http\Controllers\Api;

use App\Helper\AuthHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

class LoginApiController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $request->validated();

        AuthHelper::login(
            $request->get('username')
        );

        return response()->json([
            'success' => !!auth()->user()
        ]);
    }
}
