<?php

namespace App\Http\Requests;

use App\Rules\BlackListRule;
use App\Traits\Response\ValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommentRequest extends FormRequest
{
    use ValidationResponse;

    public function rules()
    {
        return [
            'body' => ['required', 'max:5000', new BlackListRule()],
            'parent_id' => ['nullable', 'exists:comments,id'],
            'user_id' => ['required', 'exists:users,id'],
//            'seen' => 'required',
            'approved' => ['nullable', Rule::in([0, 1])],
            'status' => ['nullable', Rule::in([0, 1])],
        ];
    }

    public function attributes()
    {
        return [
            'body' => 'نظر',
            'parent_id' => 'نظر والد',
            'user_id' => 'کاربر',
//            'seen' => 'تصویر',
            'approved' => 'وضعیت نمایش',
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
