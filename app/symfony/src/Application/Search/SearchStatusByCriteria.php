<?php

namespace App\Application\Search;

use App\Domain\Entity\Status;
use App\Domain\Repository\StatusRepositoryInterface;

class SearchStatusByCriteria
{
    public function __construct(private StatusRepositoryInterface $statusRepository)
    {
    }

    public function search(array $criteria, array $orderBy = null): ?Status
    {
        return $this->statusRepository->findOneBy($criteria, $orderBy);
    }
}