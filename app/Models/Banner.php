<?php

namespace App\Models;

use App\Casts\PersianDateCast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'start_date' => PersianDateCast::class,
        'end_date' => PersianDateCast::class,
        'image_path' => 'array'
    ];


    public function scopeSearch(Builder $query, $term = null)
    {
        return $query->when($term, function (Builder $query, $term) {
            $query->where('title', 'like', "%{$term}%")
                ->orWhere('url', 'like', "%{$term}%");
        });
    }
}
