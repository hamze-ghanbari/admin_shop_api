<?php

namespace App\Http\Requests;

use App\Rules\BlackListRule;
use App\Rules\EmailPhoneRule;
use App\Traits\Response\ValidationResponse;
use Illuminate\Foundation\Http\FormRequest;


class OtpRequest extends FormRequest
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
            'user_name' => ['bail', 'required', new EmailPhoneRule()]
        ];
    }

    public function attributes()
    {
        return [
            'user_name' => 'ایمیل یا شماره موبایل',
        ];
    }

    public function messages(){
        return [
            'user_name.required' => 'وارد کردن ایمیل یا شماره موبایل الزامی است',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_name' => convertNumbersToEnglish($this->user_name)
        ]);
    }


}
