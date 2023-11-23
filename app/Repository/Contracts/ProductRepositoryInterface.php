<?php

namespace App\Repository\Contracts;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{

    public function getProductWithTrashed($name);

}
