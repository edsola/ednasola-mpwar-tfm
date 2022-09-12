<?php

namespace App\Application\Create;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository, private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function create(User $user, string $plainPassword): void
    {
        $hashedPassword = $this->userPasswordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);
        $user->setUsername(uniqid());

        $this->userRepository->add($user, true);
    }

}

/*
public function create(string $email, string $name, string $surname, string $plainPassword, array $roles): void
{
        //$user->setUsername(strtolower($form->get('name')->getData() . $form->get('surname')->getData())  . '_' . uniqid());

}
*/