<?php

namespace App\Traits\Response;

use Illuminate\Http\Exceptions\HttpResponseException;

trait ValidationResponse
{

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException($this->failedValidationResponse($validator->getMessageBag()->getMessages()));
    }

    public function failedValidationResponse(array | string $messages, $status = 400): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => $status,
            'hasError' => true,
            'message' => $messages,
            'result' => null
        ], $status);
    }

}
