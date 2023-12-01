<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Brand extends Model
{
    use SoftDeletes;


    protected $guarded = ['id'];

    protected $casts = ['status' => 'bool'];

    public function products(){
        return $this->hasMany(Product::class);
    }

    protected function slug(): Attribute{
        return Attribute::make(
            set: fn () =>  Str::slug($this->attributes['name'])
        );
    }

    public function scopeSearch(Builder $query, $term = null)
    {
        return $query->when($term, function (Builder $query, $term) {
            $query->where('name', 'like', "%{$term}%")
                ->orWhere('persian_name', 'like', "%{$term}%");
        });
    }
}
