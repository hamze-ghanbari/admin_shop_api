<?php

namespace App\Repository\Eloquent;

use App\Models\ColorProduct;
use App\Models\GalleryProduct;
use App\Repository\Contracts\ColorProductRepositoryInterface;
use App\Repository\Contracts\GalleryProductRepositoryInterface;

class GalleryProductRepository extends BaseRepository implements GalleryProductRepositoryInterface
{
    public function model()
    {
        return GalleryProduct::class;
    }

}
