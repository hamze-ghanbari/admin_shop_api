<?php

namespace App\Repository\Eloquent;

use App\Models\Mail;
use App\Repository\Contracts\MailRepositoryInterface;
use Carbon\Carbon;

class MailRepository extends BaseRepository implements MailRepositoryInterface
{
     public function model(){
         return Mail::class;
     }

    public function getMailSearch($value){
        return $this->getModel()->search($value)->paginate();
    }

    public function getMails()
    {
        $start = Carbon::now()->toDateTimeString();
        $end = Carbon::now()->addMinutes()->toDateTimeString();
      return $this->getModel()->whereBetween('published_at', [$start, $end])->get();
    }
}
