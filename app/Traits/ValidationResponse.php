<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

trait ValidationResponse
{

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException($this->failedValidationResponse($validator->getMessageBag()->getMessages()));
    }

    public function failedValidationResponse(array | string $messages, $status = 400): \Illuminate\Http\JsonResponse
    {
        $response = [];
        $response['status'] = $status;
        $response['hasError'] = true;
        $response['messages'] = $messages;
        $response['result'] = null;

        return response()->json($response);
    }

}
