<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Role extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = ['status' => 'bool'];

    public $timestamps = false;

//    public function getCreatedAtAttribute($value)
//    {
//        return jdate($value);
//    }

    protected static function booted()
    {
        static::addGlobalScope('newRows', function (Builder $builder) {
            $builder->orderByDesc('id');
        });
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function scopeSearch(Builder $query, $term)
    {
        return $query->when($term, function(Builder $query) use ($term){
            $query->where('name', 'like', "%{$term}%")
                ->orWhere('persian_name', 'like', "%{$term}%");
        });
    }

}
