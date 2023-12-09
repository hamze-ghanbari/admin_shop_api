<?php

namespace App\Repository\Eloquent;

use App\Models\ColorProduct;
use App\Repository\Contracts\ColorProductRepositoryInterface;

class ColorProductRepository extends BaseRepository implements ColorProductRepositoryInterface
{
    public function model()
    {
        return ColorProduct::class;
    }

}
