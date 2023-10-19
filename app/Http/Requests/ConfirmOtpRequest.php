<?php

namespace App\Http\Requests;

use App\Rules\BlackListRule;
use App\Traits\ValidationResponse;
use Illuminate\Foundation\Http\FormRequest;

class ConfirmOtpRequest extends FormRequest
{
    use ValidationResponse;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'confirm_code' => ['bail', 'required', 'min:5', 'max:5', 'regex:/^[0-9]+$/', new BlackListRule()],
            'user_name' => ['bail', 'required', 'string']
        ];
    }


    public function attributes()
    {
        return [
            'token' => 'توکن',
            'confirm_code' => 'کد تایید'
        ];
    }

    public function messages(){
        return [
            'token.required' => 'وارد کردن توکن الزامی است',
            'confirm_code.required' => 'وارد کردن کد تایید الزامی است',
            'confirm_code.regex' => 'کد وارد شده باید عدد باشد',
            'confirm_code.min' => 'کد تایید نباید کمتر از 5 رقم باشد',
            'confirm_code.max' => 'کد تایید نباید بیشتر از 5 رقم باشد'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'confirm_code' => convertNumbersToEnglish($this->confirm_code)
        ]);
    }
}
