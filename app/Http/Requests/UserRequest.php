<?php

namespace App\Http\Requests;

use App\Rules\BlackListRule;
use App\Rules\NationalCodeRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
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
            'first_name' => ['max:30', new BlackListRule()],
            'last_name' => [ 'max:30', new BlackListRule()],
            'national_code' => [new NationalCodeRule()],
            'mobile' => config('constants.mobile_regex'),
            'email' => config('constants.email_regex'),
            'birth_date' => 'date_format:Y/m/d'
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => 'نام',
            'last_name' => 'نام خانوادگی',
            'national_code' => 'کد ملی',
            'mobile' => 'موبایل',
            'email' => 'ایمیل',
        ];
    }

    public function messages(){
        return [
            'birth_date.date_format' => 'فرمت تاریخ معتبر نمی باشد'
        ];
    }
}
