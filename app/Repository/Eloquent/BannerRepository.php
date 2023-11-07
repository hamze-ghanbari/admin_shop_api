<?php

namespace App\Repository\Eloquent;

use App\Models\Banner;
use App\Repository\Contracts\BannerRepositoryInterface;

class BannerRepository extends BaseRepository implements BannerRepositoryInterface
{
    public function model()
    {
        return Banner::class;
    }

}