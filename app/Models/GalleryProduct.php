<?php

namespace App\Models;

use App\Casts\PersianDateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'image' => 'array',
    ];

    public function product(){
        return $this->belongsToMany(Product::class);
    }
}
