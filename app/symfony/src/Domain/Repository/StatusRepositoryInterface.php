<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Status;

interface StatusRepositoryInterface
{
    public function add(Status $entity, bool $flush = false): void;
    public function remove(Status $entity, bool $flush = false): void;
}