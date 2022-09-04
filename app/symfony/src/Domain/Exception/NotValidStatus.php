<?php

namespace App\Domain\Exception;

use DomainException;

final class NotValidStatus extends DomainException
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
        return 'The status code is not correct';
    }
}