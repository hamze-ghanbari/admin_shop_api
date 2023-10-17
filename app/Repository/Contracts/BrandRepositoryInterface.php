<?php

namespace App\Repository\Contracts;

interface BrandRepositoryInterface extends BaseRepositoryInterface
{
    public function getBrandSearch($value);

    public function getBrandWithTrashed($name);
}
