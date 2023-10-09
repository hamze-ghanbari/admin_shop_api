<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{

    public function apiResponse(array | object | null $result, int $status = 200, string $message = null, $hasError = false): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'hasError' => $hasError,
            'message' => $message,
            'result' => $result
        ]);
    }

    public function forbiddenResponse(): JsonResponse
    {
        return $this->apiResponse(null, 403, 'forbidden', true);
    }

    public function serverError($message = 'خطای سرور'): JsonResponse
    {
        return $this->apiResponse(null, 500, $message, true);
    }

    public function sameUser($userId): bool
    {
        return auth()->user() === $userId;
    }

}
