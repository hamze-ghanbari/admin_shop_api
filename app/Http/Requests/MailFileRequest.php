<?php

namespace App\Http\Requests;

use App\Rules\BlackListRule;
use App\Traits\Response\ValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MailFileRequest extends FormRequest
{
    use ValidationResponse;

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'file_path' => ['required', new BlackListRule()],
            'file_name' => ['nullable', 'max:150', new BlackListRule()],
            'status' => [Rule::in([0,1])],
            'mime_type' => "mimetypes:text/csv,image/jpeg,image/png,audio/mpeg,video/mp4,application/pdf,image/webp,application/zip",
            'mail_id' => 'required|exists:mails,id'
        ];
    }

    public function attributes()
    {
        return [
            'file_path' => 'فایل',
            'file_name' => 'نام فایل',
            'status' => 'وضعیت فایل',
            'mime_type' => 'نوع فایل',
//            'mail_id' => 'وضعیت ارسال',
        ];
    }

//    public function messages(): array
//    {
//        return [
//            'published_at.date_format' => 'فرمت تاریخ معتبر نمی باشد'
//        ];
//    }
}
