<?php

namespace App\Repository\Eloquent;

use App\Models\MetaProduct;
use App\Models\Product;
use App\Repository\Contracts\MetaProductRepositoryInterface;

class MetaProductRepository extends BaseRepository implements MetaProductRepositoryInterface
{
    public function model()
    {
        return MetaProduct::class;
    }

//    public function getProductWithTrashed($name){
//        return $this->getModel()->withTrashed()->where(['name' => $name])->exists();
//    }
//
//    public function getProductSearch($value){
//        return $this->getModel()->search($value)->paginate();
//    }
}
