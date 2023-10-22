<?php

namespace App\Http\Requests;

use App\Rules\BlackListRule;
use App\Traits\Response\ValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MailRequest extends FormRequest
{
    use ValidationResponse;

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'subject' => ['required', new BlackListRule()],
            'body' => ['required', new BlackListRule()],
            'published_at' => ['required', 'date_format:Y/m/d'],
            'status' => [Rule::in([0,1])],
            'shipping_status' => [Rule::in([0,1])],
            'user_id' => 'bail|nullable|exists:users,id'
        ];
    }
}
