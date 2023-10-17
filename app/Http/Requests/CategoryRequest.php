<?php

namespace App\Http\Requests;

use App\Rules\BlackListRule;
use App\Traits\ValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    use ValidationResponse;
    public function rules()
    {
        return [
            'name' => ['required', 'max:50', 'regex:/^([a-z A-Z]{1,50})$/'],
            'persian_name' => ['required', 'max:50', 'regex:/^([ ضصثقفغعهخحجچشسیبلاتنمکگپظطزر ذدئو.ء ِ]{1,50})$/'],
            'description' => ['required', 'max:5000', new BlackListRule()],
//            'image' => 'required',
            'status' => [Rule::in([1, 2])],
            'show_in_menu' => [Rule::in([1, 2])],
            'parent_id' => ['nullable', 'exists:categories,id', new BlackListRule()]
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام دسته بندی (انگلیسی)',
            'persian_name' => 'نام دسته بندی (فارسی)',
            'description' => 'توضیحات دسته بندی',
            'image' => 'تصویر دسته بندی',
            'status' => 'وضعیت',
            'show_in_menu' => 'وضعیت نمایش',
            'parent_id' => 'دسته بندی والد'
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'نام دسته بندی باید به صورت حروف انگلیسی باشد',
            'persian_name.regex' => 'نام دسته بندی باید به صورت حروف فارسی باشد',
            'image.image' => 'فرمت تصویر نامعتبر است'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
