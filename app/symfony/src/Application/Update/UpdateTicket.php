<?php

namespace App\Application\Update;

use App\Domain\Entity\Priority;
use App\Domain\Entity\Ticket;
use App\Domain\Entity\User;
use App\Domain\Repository\TicketRepositoryInterface;

class UpdateTicket
{
    public function __construct(private TicketRepositoryInterface $ticketRepository)
    {
    }

    public function update(Ticket $ticket, string $title, string $description, Priority $priority, User $technician): void
    {
        $ticket->setTitle($title);
        $ticket->setDescription($description);
        $ticket->setPriorityId($priority);
        $ticket->setTechnicianUserId($technician);

        $this->ticketRepository->add($ticket, true);
    }
}