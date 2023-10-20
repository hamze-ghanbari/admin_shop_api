<?php

namespace App\Traits\Response;

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

    public function forbiddenResponse($message = 'عدم دسترسی'): JsonResponse
    {
        return $this->apiResponse(null, 403, $message, true);
    }

    public function serverError($message = 'خطای سرور'): JsonResponse
    {
        return $this->apiResponse(null, 500, $message, true);
    }

    public function tooManyRequests($result, $message = 'تعداد بیش از حد درخواست'): JsonResponse
    {
        return $this->apiResponse($result, 429, $message);
    }

}
