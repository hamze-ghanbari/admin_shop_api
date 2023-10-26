<?php

namespace App\Models;

use App\Casts\PersianDateCast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mail extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => PersianDateCast::class,
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function files(){
        return $this->hasMany(MailFile::class);
    }

    public function scopeSearch(Builder $query, $term)
    {
        return $query->when($term, function(Builder $query) use ($term){
            $query->where('subject', 'like', "%{$term}%");
        });
    }
}
