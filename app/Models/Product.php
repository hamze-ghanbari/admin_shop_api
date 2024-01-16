<?php

namespace App\Models;

use App\Casts\PersianDateCast;
use Illuminate\Database\Eloquent\Builder;
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
        'marketable' => 'bool',
        'published_at' => PersianDateCast::class
    ];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function category(){
        return $this->belongsTo(CategoryProduct::class);
    }

    public function metas(){
        return $this->hasMany(MetaProduct::class);
    }

    public function colors(){
        return $this->hasMany(ColorProduct::class);
    }

    public function images(){
        return $this->hasMany(GalleryProduct::class);
    }

    public function values(){
        return $this->hasMany(AttributeValueCategory::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    protected function slug(): Attribute{
        return Attribute::make(
            set: fn () =>  Str::slug($this->attributes['name'])
        );
    }

    public function scopeSearch(Builder $query, $term = null)
    {
        return $query->when($term, function (Builder $query, $term) {
            $query->where('name', 'like', "%{$term}%");
        });
    }

}
