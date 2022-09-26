<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

interface UserRepositoryInterface
{
    public function add(User $entity, bool $flush = false): void;
    public function remove(User $entity, bool $flush = false): void;
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void;
    public function findByRole($role): array;
}