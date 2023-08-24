<?php

namespace App\Repository\Contracts;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function notionalCodeExists($nationalCode);
}
