<?php

namespace App\Repository\Eloquent;

use App\Models\Mail;
use App\Repository\Contracts\MailRepositoryInterface;

class MailRepository extends BaseRepository implements MailRepositoryInterface
{
     public function model(){
         return Mail::class;
     }

    public function getMailSearch($value){
        return $this->getModel()->search($value)->paginate();
    }
}
