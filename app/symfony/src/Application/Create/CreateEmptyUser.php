<?php

namespace App\Application\Create;

use App\Domain\Entity\User;

class CreateEmptyUser
{
    public function create(): User
    {
        return new User();
    }
}