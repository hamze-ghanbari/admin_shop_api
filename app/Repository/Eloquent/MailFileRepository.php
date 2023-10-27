<?php

namespace App\Repository\Eloquent;

use App\Models\MailFile;
use App\Repository\Contracts\MailFileRepositoryInterface;

class MailFileRepository extends BaseRepository implements MailFileRepositoryInterface
{
     public function model(){
         return MailFile::class;
     }

}
