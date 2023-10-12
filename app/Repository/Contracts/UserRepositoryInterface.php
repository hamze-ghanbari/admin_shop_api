<?php

namespace App\Repository\Contracts;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function getUserByField($field, $value);

    public function notionalCodeExists($nationalCode);

    public function getUserSearch($value);
}
