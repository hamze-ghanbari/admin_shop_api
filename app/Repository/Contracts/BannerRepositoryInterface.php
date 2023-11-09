<?php

namespace App\Repository\Contracts;

interface BannerRepositoryInterface extends BaseRepositoryInterface
{
    public function getBannerSearch($value);
}
