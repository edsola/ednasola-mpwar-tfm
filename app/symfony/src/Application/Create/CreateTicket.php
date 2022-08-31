<?php

namespace App\Application\Create;

date_default_timezone_set("Europe/Madrid");

use App\Application\Search\SearchStatusByCriteria;
use App\Domain\Entity\Ticket;
use App\Domain\Entity\User;
use App\Domain\Repository\TicketRepositoryInterface;
use DateTime;

class CreateTicket
{
    public function __construct(
        private TicketRepositoryInterface $ticketRepository,
        private SearchStatusByCriteria $searchStatusByCriteria
    ) {
    }

    public function create(Ticket $ticket, User $admin): void
    {
        $openStatus = $this->searchStatusByCriteria->search(['id' => 1]);
        $ticket->setCreatedDate(new DateTime());
        $ticket->setAdminUserId($admin);
        $ticket->setStatusId($openStatus);

        $this->ticketRepository->add($ticket, true);
    }
}