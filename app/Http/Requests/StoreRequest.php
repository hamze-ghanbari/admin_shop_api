<?php

namespace App\Http\Requests;

use App\Rules\BlackListRule;
use App\Traits\Response\ValidationResponse;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'sold_number' => ['numeric', new BlackListRule()],
            'frozen_number' => ['numeric', new BlackListRule()],
            'marketable_number' => ['numeric', new BlackListRule()],
        ];
    }

    public function attributes()
    {
        return [
            'sold_number' => 'تعداد فروخته شده',
            'frozen_number' => 'تعداد رزرو شده',
            'marketable_number' => 'تعداد قابل فروش',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'sold_number' => (int) convertNumbersToEnglish($this->sold_number),
            'frozen_number' => (int) convertNumbersToEnglish($this->frozen_number),
            'marketable_number' => (int) convertNumbersToEnglish($this->marketable_number),
        ]);
    }

}
