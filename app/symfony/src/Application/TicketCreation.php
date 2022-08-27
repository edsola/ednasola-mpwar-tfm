<?php

namespace App\Application;

date_default_timezone_set("Europe/Madrid");

use App\Domain\Entity\Ticket;
use App\Domain\Entity\User;
use App\Domain\Repository\TicketRepositoryInterface;
use DateTime;

class TicketCreation
{
    public function __construct(private TicketRepositoryInterface $ticketRepository, private StatusSearchByCriteria $statusSearchByCriteria)
    {
    }

    public function create(Ticket $ticket, User $admin)
    {
        $openStatus = $this->statusSearchByCriteria->search(['id' => 1]);
        $ticket->setCreatedDate(new DateTime());
        $ticket->setAdminUserId($admin);
        $ticket->setStatusId($openStatus);

        $this->ticketRepository->add($ticket, true);
    }
}