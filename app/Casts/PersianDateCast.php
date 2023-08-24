<?php

namespace App\Casts;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class PersianDateCast implements CastsAttributes
{

    public function get(Model $model, string $key, mixed $value, array $attributes): string | null
    {
        return isset($value) ? jalaliDate($value, 'Y/m/d') : null;
    }


    public function set(Model $model, string $key, mixed $value, array $attributes): Carbon
    {
        return Jalalian::fromFormat('Y/m/d', $value)->toCarbon();
    }
}
