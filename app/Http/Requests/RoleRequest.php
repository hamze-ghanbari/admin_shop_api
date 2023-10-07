<?php

namespace App\Http\Requests;

use App\Rules\BlackListRule;
use App\Traits\ValidationResponse;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => ['required', 'max:30', 'regex:/^([a-z A-Z]{1,30})$/'],
            'persian_name' => ['required', 'max:30', 'regex:/^([ ضصثقفغعهخحجچشسیبلاتنمکگپظطزرذدئو.ءِ]{1,30})$/'],
            'status' => [new BlackListRule()]
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام نقش',
            'persian_name' => 'نام نقش',
            'status' => 'وضعیت نقش'
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'نام نقش باید به صورت حروف انگلیسی باشد',
            'persian_name.regex' => 'نام نقش باید به صورت حروف فارسی باشد',
        ];
    }
}
