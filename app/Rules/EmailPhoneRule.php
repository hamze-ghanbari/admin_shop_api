<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Config;

class EmailPhoneRule implements ValidationRule
{

    public function validate($attribute, $value, $fail):void
    {
        if(!preg_match('/^('.Config::get('constants.mobile_regex').'|'. Config::get('constants.email_regex').')$/', $value)){
            $fail('ایمیل یا شماره موبایل وارد شده معتبر نمی باشد');
        }
    }
}
