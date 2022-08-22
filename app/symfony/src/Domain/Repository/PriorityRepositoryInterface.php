<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Priority;

interface PriorityRepositoryInterface
{
    public function add(Priority $entity, bool $flush = false): void;
    public function remove(Priority $entity, bool $flush = false): void;
}