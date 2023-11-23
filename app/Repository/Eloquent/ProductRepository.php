<?php

namespace App\Repository\Eloquent;

use App\Models\Product;
use App\Repository\Contracts\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function model()
    {
        return Product::class;
    }

    public function getProductWithTrashed($name){
        return $this->getModel()->withTrashed()->where(['name' => $name])->exists();
    }

    public function getProductSearch($value){
        return $this->getModel()->search($value)->paginate();
    }
}
