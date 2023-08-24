<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BlackListRule implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $blackWords = [];
        $blackList = ["!", "'", ';', '<', '>', '#', '%27', 'script', 'delete', 'DELETE', 'hack', '"', 'cookie', 'document', 'alert', '<script>', '</script>', 'document.cookie'];
        foreach ($blackList as  $val) {
            if (str_contains(trim($value), $val)) {
                array_push($blackWords, $val);
            }
        }
        if (sizeof($blackWords) > 0) {
            $word = sizeof($blackWords) > 1 ? 'کلمات' : 'کلمه';
            $blackWords = join(' , ', $blackWords);
            $fail("وارد کردن $word $blackWords مجاز نمی باشد");
        }

    }
}
