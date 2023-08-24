<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NationalCodeRule implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!validateNationalCode($value)){
            $fail('کد ملی وارد شده معتبر نمی باشد');
        }
    }
}
