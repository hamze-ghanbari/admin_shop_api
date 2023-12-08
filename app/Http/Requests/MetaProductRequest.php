<?php

namespace App\Http\Requests;

use App\Rules\BlackListRule;
use App\Rules\NationalCodeRule;
use App\Traits\Response\ValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MetaProductRequest extends FormRequest
{
    use ValidationResponse;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            '*.meta_key' => ['required', 'distinct', new BlackListRule()],
            '*.meta_value' => ['required', 'distinct', new BlackListRule()],
        ];
    }

    public function attributes()
    {
        return [
            '*.meta_key' => 'نام ویژگی',
            '*.meta_value' => 'مقدار ویژگی',
        ];
    }

}
