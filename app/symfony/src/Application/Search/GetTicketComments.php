<?php

namespace App\Application\Search;

use App\Domain\Entity\Ticket;
use Doctrine\ORM\PersistentCollection;

class GetTicketComments
{
    public function get(Ticket $ticket): PersistentCollection
    {
        return $ticket->getComments();
    }
}