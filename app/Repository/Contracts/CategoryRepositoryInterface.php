<?php

namespace App\Repository\Contracts;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function getCategoryWithTrashed($name);

    public function getCategorySearch($value);
}
