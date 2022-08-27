<?php

namespace App\Application;

use App\Domain\Entity\Status;
use App\Domain\Repository\StatusRepositoryInterface;

class StatusSearchByCriteria
{
    public function __construct(private readonly StatusRepositoryInterface $repository)
    {
    }

    public function search(array $criteria, array $orderBy = null): ?Status
    {
        return $this->repository->findOneBy($criteria, $orderBy);
    }
}