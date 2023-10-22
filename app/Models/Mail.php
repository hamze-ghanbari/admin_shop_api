<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mail extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function scopeSearch(Builder $query, $term)
    {
        return $query->when($term, function(Builder $query) use ($term){
            $query->where('subject', 'like', "%{$term}%");
        });
    }
}
