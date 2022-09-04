<?php

namespace App\Domain\Exception;

use DomainException;

class NotValidLabel extends DomainException
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
        return 'The label you want to see does not exist';
    }
}