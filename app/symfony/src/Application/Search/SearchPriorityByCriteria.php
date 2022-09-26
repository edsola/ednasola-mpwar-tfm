<?php

namespace App\Application\Search;

use App\Domain\Entity\Priority;
use App\Domain\Exception\NotValidPriority;
use App\Domain\Repository\PriorityRepositoryInterface;

class SearchPriorityByCriteria
{
    public function __construct(private PriorityRepositoryInterface $priorityRepository)
    {
    }

    public function search(array $criteria, array $orderBy = null): ?Priority
    {
        $priority = $this->priorityRepository->findOneBy($criteria, $orderBy);

        if ($priority === null) {
            throw new NotValidPriority();
        }
        return $priority;
    }

    public function searchAll(array $criteria, array $orderBy = null): array
    {
        $priority = $this->priorityRepository->findBy($criteria, $orderBy);

        if ($priority === null) {
            throw new NotValidPriority();
        }
        return $priority;
    }
}