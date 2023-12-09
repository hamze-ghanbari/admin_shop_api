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
}
