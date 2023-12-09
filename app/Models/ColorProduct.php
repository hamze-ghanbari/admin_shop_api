<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ColorProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];


    protected $casts = [
        'status' => 'bool',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
