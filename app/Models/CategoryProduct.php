<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CategoryProduct extends Model
{
    use  SoftDeletes;

//    protected $table = 'category_products';

    protected $guarded = ['id'];

    protected $casts = ['status' => 'bool'];

    public function parent()
    {
        return $this->belongsTo($this, 'parent_id')->with('parent');
    }

    public function childrens()
    {
        return $this->hasMany($this, 'parent_id')->with('childrens');
    }

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
