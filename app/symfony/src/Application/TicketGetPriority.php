<?php

namespace App\Application;

use App\Domain\Entity\Priority;
use App\Domain\Entity\Ticket;

class TicketGetPriority
{
    public function get(Ticket $ticket): Priority
    {
        return $ticket->getPriorityId();
    }
}