<?php

namespace App\Application\Search;

use App\Domain\Entity\Status;
use App\Domain\Exception\NotValidStatus;
use App\Domain\Repository\StatusRepositoryInterface;

class SearchStatusByCriteria
{
    public function __construct(private StatusRepositoryInterface $statusRepository)
    {
    }

    public function search(array $criteria, array $orderBy = null): ?Status
    {
        $status = $this->statusRepository->findOneBy($criteria, $orderBy);

        if ($status === null) {
            throw new NotValidStatus();
        }
        return $status;
    }

    public function searchAll(array $criteria, array $orderBy = null): array
    {
        $status = $this->statusRepository->findBy($criteria, $orderBy);

        if ($status === null) {
            throw new NotValidStatus();
        }
        return $status;
    }
}