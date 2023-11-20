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

}
