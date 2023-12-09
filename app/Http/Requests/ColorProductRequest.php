<?php

namespace App\Http\Requests;

use App\Rules\BlackListRule;
use App\Traits\Response\ValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ColorProductRequest extends FormRequest
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
            'color_name' => ['required', 'max:50', new BlackListRule()],
            'price_increase' => ['nullable', 'digits_between:1,10'],
            'status' => ['nullable', Rule::in([0, 1])]
        ];
    }

    public function attributes()
    {
        return [
            'color_name' => 'نام رنگ',
            'price_increase' => 'افزایش قیمت',
            'status' => 'وضعیت',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'price_increase' => (int) convertNumbersToEnglish($this->price_increase),
        ]);
    }

}
