<?php

namespace App\Application\Search;

use App\Domain\Repository\PriorityRepositoryInterface;

class GetPriorities
{
    public function __construct(private PriorityRepositoryInterface $priorityRepository)
    {
    }

    public function get(): array
    {
        $priorities = $this->priorityRepository->findAll();
        return $priorities;
    }
}