<?php

namespace App\Repository\Eloquent;

use App\Models\AttributeCategory;
use App\Repository\Contracts\AttributeRepositoryInterface;

class AttributeRepository extends BaseRepository implements AttributeRepositoryInterface
{
     public function model(){
         return AttributeCategory::class;
     }

    public function getAttributeSearch($value){
        return $this->getModel()->search($value)->paginate();
    }
}
