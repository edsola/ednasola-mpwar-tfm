<?php

namespace App\Domain\ObjectMother;

use App\Domain\Entity\User;

class UserExample
{
    public static function adminUser(): User
    {
        $user = new User();
        $user->setEmail('adminUser@test.com');
        $user->setName('User');
        $user->setSurname('Admin');
        $user->setPassword('$2y$13$cq23FEAjdr6lzOxCqN5j5uv1o1ZKDf4ZvG2txCasmPGXHqCQjHtqG');
        $user->setRoles(["ROLE_ADMIN"]);

        return $user;
    }

    public static function technicianUser(): User
    {
        $user = new User();
        $user->setEmail('technicianUser@test.com');
        $user->setName('User');
        $user->setSurname('Technician');
        $user->setPassword('$2y$13$cq23FEAjdr6lzOxCqN5j5uv1o1ZKDf4ZvG2txCasmPGXHqCQjHtqG');
        $user->setRoles(["ROLE_TECHNICIAN"]);

        return $user;
    }
}