<?php

namespace App\Repository\Contracts;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function checkRole($name, $persianName);

}
