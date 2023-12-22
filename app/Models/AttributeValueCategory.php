<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class AttributeValueCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $table = 'category_values';

    public function attribute(){
        return $this->belongsTo(AttributeCategory::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }


//    public function scopeSearch(Builder $query, $term = null)
//    {
//        return $query->when($term, function (Builder $query, $term) {
//            $query->where('name', 'like', "%{$term}%")
//                ->orWhere('unit', 'like', "%{$term}%");
//        });
//    }
}
