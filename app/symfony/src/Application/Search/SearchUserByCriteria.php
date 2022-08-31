<?php

namespace App\Application\Search;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;

class SearchUserByCriteria
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function searchOne(array $criteria, array $orderBy = null): ?User
    {
        return $this->userRepository->findOneBy($criteria, $orderBy);
    }

    public function searchAll(array $criteria, array $orderBy = null): array
    {
        return $this->userRepository->findBy($criteria, $orderBy);
    }
}