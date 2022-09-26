<?php

namespace App\Application\Create;

use App\Domain\Entity\Ticket;

class CreateEmptyTicket
{
    public function create(): Ticket
    {
        return new Ticket();
    }
}