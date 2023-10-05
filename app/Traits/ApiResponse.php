<?php

namespace App\Traits;

trait ApiResponse
{

    public function apiResponse(array | object $result, int $status = 200, string $message = null): \Illuminate\Http\JsonResponse
    {
        $response = [];
        $response['status'] = $status;
        $response['hasError'] = false;
        $response['message'] = $message;
        $response['result'] = $result;

        return response()->json($response);
    }

}
