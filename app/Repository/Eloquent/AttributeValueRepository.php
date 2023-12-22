<?php

namespace App\Repository\Eloquent;

use App\Models\AttributeCategory;
use App\Models\AttributeValueCategory;
use App\Repository\Contracts\AttributeRepositoryInterface;
use App\Repository\Contracts\AttributeValueRepositoryInterface;

class AttributeValueRepository extends BaseRepository implements AttributeValueRepositoryInterface
{
     public function model(){
         return AttributeValueCategory::class;
     }

}
