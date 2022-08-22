<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function add(User $entity, bool $flush = false): void;
    public function remove(User $entity, bool $flush = false): void;
}