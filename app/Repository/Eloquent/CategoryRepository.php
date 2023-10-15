<?php

namespace App\Repository\Eloquent;

use App\Models\Category;
use App\Repository\Contracts\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
     public function model(){
         return Category::class;
     }

    public function getCategoryWithTrashed($name){
        return $this->getModel()->withTrashed()->where(['name' => $name])->exists();
    }

    public function getCategorySearch($value){
        return $this->getModel()->search($value)->paginate();
    }
}
