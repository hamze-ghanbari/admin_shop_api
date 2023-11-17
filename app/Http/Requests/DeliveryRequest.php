<?php

namespace App\Http\Requests;

use App\Rules\BlackListRule;
use App\Traits\Response\ValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeliveryRequest extends FormRequest
{
    use ValidationResponse;

    public function rules()
    {
        return [
            'name' => ['required', 'max:50', new BlackListRule()],
            'amount' => 'digits_between:3,7',
            'delivery_time' => ['bail', 'integer', new BlackListRule()],
            'delivery_time_unit' => [Rule::in(['سال', 'ماه', 'هفته', 'روز'])],
            'status' => [Rule::in([0, 1])],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'روش ارسال',
            'amount' => 'مبلغ',
            'delivery_time' => 'زمان تحویل',
//            'delivery_time_unit' => 'واحد زمان تحویل',
            'status' => 'وضعیت',
        ];
    }

    public function messages(): array
    {
        return [
            'delivery_time_unit.in' => 'واحد زمان تحویل نامعتبر است'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
