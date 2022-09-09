<?php

namespace App\Domain\Exception;

use DomainException;

class NotValidPriority extends DomainException
{
    public function __construct()
    {
        parent::__construct($this->errorMessage());
    }

    public function errorCode(): string
    {
        return 'invalid_name';
    }

    private function errorMessage(): string
    {
        return 'The priority you want to see does not exist';
    }
}