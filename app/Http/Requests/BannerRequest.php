<?php

namespace App\Http\Requests;

use App\Rules\BlackListRule;
use App\Traits\Response\ValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BannerRequest extends FormRequest
{
    use ValidationResponse;

    public function rules()
    {
        return [
            'title' => ['required', 'max:100', new BlackListRule()],
            'url' => ['required', new BlackListRule()],
            'start_date' => ['required', 'date_format:Y/m/d'],
            'end_date' => ['required', 'date_format:Y/m/d'],
            'image_path' => 'required',
            'status' => [Rule::in([0, 1])],
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'عنوان',
            'url' => 'لینک',
            'start_date' => 'تاریخ شروع نمایش',
            'end_date' => 'تاریخ پایان نمایش',
            'image_path' => 'تصویر',
            'status' => 'وضعیت',
        ];
    }

    public function messages(): array
    {
        return [
//            'name.regex' => 'نام برند باید به صورت حروف انگلیسی باشد',
//            'persian_name.regex' => 'نام برند باید به صورت حروف فارسی باشد',
//            'image.image' => 'فرمت تصویر نامعتبر است'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
