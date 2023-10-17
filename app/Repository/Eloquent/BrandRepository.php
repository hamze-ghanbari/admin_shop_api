<?php

namespace App\Repository\Eloquent;

use App\Models\Brand;
use App\Models\Category;
use App\Repository\Contracts\BrandRepositoryInterface;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    public function model()
    {
        return Brand::class;
    }

    public function getBrandSearch($value){
        return $this->getModel()->search($value)->paginate();
    }

    public function getBrandWithTrashed($name){
        return $this->getModel()->withTrashed()->where(['name' => $name])->exists();
    }

}
