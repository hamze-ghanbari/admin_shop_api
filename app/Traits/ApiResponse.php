<?php

namespace App\Traits;

trait ApiResponse
{

    public function apiResponse(array | object | null $result, int $status = 200, string $message = null, $hasError = false): \Illuminate\Http\JsonResponse
    {
        $response = [];
        $response['status'] = $status;
        $response['hasError'] = $hasError;
        $response['message'] = $message;
        $response['result'] = $result;

        return response()->json($response);
    }

}
