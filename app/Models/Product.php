<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'bool',
        'marketable' => 'bool'
    ];

    protected function slug(): Attribute{
        return Attribute::make(
            set: fn () =>  Str::slug($this->attributes['name'])
        );
    }
}
