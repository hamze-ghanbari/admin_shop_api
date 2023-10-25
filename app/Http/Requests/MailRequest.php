<?php

namespace App\Http\Requests;

use App\Rules\BlackListRule;
use App\Traits\Response\ValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MailRequest extends FormRequest
{
    use ValidationResponse;

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'subject' => ['required', new BlackListRule()],
            'body' => ['required', new BlackListRule()],
            'published_at' => ['required', 'date_format:Y/m/d'],
            'status' => [Rule::in([0,1])],
            'shipping_status' => [Rule::in([0,1])],
            'user_id' => 'bail|nullable|exists:users,id'
        ];
    }

    public function attributes()
    {
        return [
            'subject' => 'موضوع ایمیل',
            'body' => 'متن ایمیل',
            'published_at' => 'تاریخ ارسال',
            'status' => 'وضعیت نمایش',
            'shipping_status' => 'وضعیت ارسال',
            'user_id' => 'نام کاربر'
        ];
    }

    public function messages(): array
    {
        return [
            'published_at.date_format' => 'فرمت تاریخ معتبر نمی باشد'
        ];
    }
}
