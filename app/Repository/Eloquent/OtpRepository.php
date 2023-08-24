<?php

namespace App\Repository\Eloquent;

use App\Models\Otp;
use App\Repository\Contracts\OtpRepositoryInterface;

class OtpRepository extends BaseRepository implements OtpRepositoryInterface
{
     public function model(){
         return Otp::class;
     }
}
