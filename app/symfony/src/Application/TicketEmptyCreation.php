<?php

namespace App\Application;

use App\Domain\Entity\Ticket;

class TicketEmptyCreation
{
    public function create(): Ticket
    {
        return new Ticket();
    }
}