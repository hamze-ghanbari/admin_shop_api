<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\Contracts\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
     public function model(){
         return User::class;
     }

    public function getUserByField($field, $value){
        return $this->findWhere([$field => $value])->withTrashed()->first();
    }

    public function notionalCodeExists($nationalCode)
    {
        return $this->getModel()->withTrashed()->where($nationalCode)->exists();
    }


}
