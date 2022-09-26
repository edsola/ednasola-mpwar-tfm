<?php

namespace App\Application\Search;

use App\Domain\Entity\Priority;
use App\Domain\Entity\Ticket;

class GetTicketPriority
{
    public function get(Ticket $ticket): Priority
    {
        return $ticket->getPriorityId();
    }
}