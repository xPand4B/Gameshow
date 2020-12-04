<?php

namespace App\Helper;

use Illuminate\Http\JsonResponse;

class MessageResponse
{
    /**
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function json(string $message, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'message' => [
                'status' => $statusCode,
                'text' => $message
            ]
        ], $statusCode);
    }
}
