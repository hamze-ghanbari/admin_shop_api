<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

class Delivery extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = ['status' => 'bool'];

    public function scopeSearch(Builder $query, $term = null)
    {
        return $query->when($term, function (Builder $query, $term) {
            $query->where('name', 'like', "%{$term}%");
        });
    }
}
