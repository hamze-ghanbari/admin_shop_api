<?php

namespace App\Http\Requests;

use App\Rules\BlackListRule;
use App\Traits\Response\ValidationResponse;
use Illuminate\Foundation\Http\FormRequest;

class AttributeCategoryRequest extends FormRequest
{
    use ValidationResponse;
    public function rules()
    {
        return [
            'name' => ['required', 'max:100', new BlackListRule()],
            'unit' => ['required', new BlackListRule()],
            'category_id' => ['bail', 'required', 'integer', 'exists:category_products,id'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام فرم',
            'unit' => 'واحد اندازه گیری',
            'category_id' => 'دسته بندی',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
