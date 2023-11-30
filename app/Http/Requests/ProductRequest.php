<?php

namespace App\Http\Requests;

use App\Rules\BlackListRule;
use App\Rules\NationalCodeRule;
use App\Traits\Response\ValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'name' => ['required', new BlackListRule()],
            'introduction' => ['required', new BlackListRule()],
            'weight' => ['required', 'digits_between:1,10'],
            'length' => ['required', 'digits_between:1,10'],
            'width' => ['required', 'digits_between:1,10'],
            'height' => ['required', 'digits_between:1,10'],
            'price' => ['required', 'digits_between:1,10'],
            'status' => [Rule::in([0, 1])],
            'marketable' => [Rule::in([0, 1])],
            'sold_number' => ['numeric', new BlackListRule()],
            'frozen_number' => ['numeric', new BlackListRule()],
            'marketable_number' => ['numeric', new BlackListRule()],
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
            'category_id' => ['required', 'integer', 'exists:category_products,id'],
            'published_at' => ['date_format:Y/m/d']
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام محصول',
            'introduction' => 'توضیحات',
            'weight' => 'وزن محصول',
            'length' => 'طول محصول',
            'width' => 'عرض محصول',
            'height' => 'ارتفاع محصول',
            'price' => 'قیمت محصول',
            'status' => 'وضعیت محصول',
            'marketable' => 'قابل فروش بودن',
            'sold_number' => 'تعداد فروخته شده',
            'frozen_number' => '',
            'marketable_number' => 'تعداد قابل فروش',
            'brand_id' => 'برند محصول',
            'category_id' => 'دسته بندی محصول',
            'published_at' => 'تاریخ انتشار',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'price' => (int) convertNumbersToEnglish($this->price),
            'sold_number' => (int) convertNumbersToEnglish($this->sold_number),
            'frozen_number' => (int) convertNumbersToEnglish($this->frozen_number),
            'marketable_number' => (int) convertNumbersToEnglish($this->marketable_number),
        ]);
    }

    public function messages()
    {
        return [
//            'national_code.required' => 'وارد کردن کد ملی الزامی است',
//            'birth_date.date_format' => 'فرمت تاریخ معتبر نمی باشد'
        ];
    }
}
