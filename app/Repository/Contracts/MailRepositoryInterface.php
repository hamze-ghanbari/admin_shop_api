<?php

namespace App\Repository\Contracts;

interface MailRepositoryInterface extends BaseRepositoryInterface
{
    public function getMailSearch($value);

}
