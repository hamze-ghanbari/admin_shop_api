<?php

namespace App\Http\Requests;

use App\Rules\BlackListRule;
use App\Traits\Response\ValidationResponse;
use Illuminate\Foundation\Http\FormRequest;

class AttributeValueRequest extends FormRequest
{
    use ValidationResponse;
    public function rules()
    {
        return [
            'type' => ['required', new BlackListRule()],
            'value' => ['required', new BlackListRule()],
            'price_increase' => ['required', 'digits_between:1,10'],
            'product_id' => ['bail', 'required', 'integer', 'exists:products,id'],
        ];
    }

    public function attributes()
    {
        return [
            'type' => 'نوع',
            'value' => 'مقدار',
            'price_increase' => 'افزایش قیمت',
            'product_id' => 'محصول',
        ];
    }

//    public function messages(){
//        return [
//            'value.json' => 'مقدار باید یک رشته JSON معتبر باشد'
//        ];
//    }

    public function authorize()
    {
        return true;
    }
}
