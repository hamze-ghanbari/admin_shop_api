<?php

namespace App\Repository\Eloquent;

use App\Models\Delivery;
use App\Repository\Contracts\DeliveryRepositoryInterface;

class DeliveryRepository extends BaseRepository implements DeliveryRepositoryInterface
{
    public function model()
    {
        return Delivery::class;
    }

    public function getDeliverySearch($value){
        return $this->getModel()->search($value)->paginate();
    }

}
