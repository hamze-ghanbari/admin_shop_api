<?php

namespace App\Repository\Contracts;

interface AttributeRepositoryInterface extends BaseRepositoryInterface
{
    public function getAttributeSearch($value);
}
