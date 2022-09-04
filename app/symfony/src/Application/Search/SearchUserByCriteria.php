<?php

namespace App\Application\Search;

use App\Domain\Entity\User;
use App\Domain\Exception\NotValidUser;
use App\Domain\Repository\UserRepositoryInterface;

class SearchUserByCriteria
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function searchOne(array $criteria, array $orderBy = null): ?User
    {
        $user = $this->userRepository->findOneBy($criteria, $orderBy);

        if ($user === null) {
            throw new NotValidUser();
        }

        return $user;
    }

    public function searchAll(array $criteria, array $orderBy = null): array
    {
        return $this->userRepository->findBy($criteria, $orderBy);
    }
}