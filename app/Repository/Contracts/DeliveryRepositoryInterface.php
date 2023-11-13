<?php

namespace App\Repository\Contracts;

interface DeliveryRepositoryInterface extends BaseRepositoryInterface
{
    public function getDeliverySearch($value);
}
