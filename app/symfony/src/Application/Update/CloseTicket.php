<?php

namespace App\Application\Update;

use App\Application\Search\SearchStatusByCriteria;
use App\Application\Search\SearchTicketByCriteria;
use App\Domain\Repository\TicketRepositoryInterface;

class CloseTicket
{
    public function __construct(
        private SearchTicketByCriteria $searchTicketByCriteria,
        private SearchStatusByCriteria $searchStatusByCriteria,
        private TicketRepositoryInterface $ticketRepository
    ) {
    }

    public function close(int $id): void
    {
        $ticket = $this->searchTicketByCriteria->searchOne(['id' => $id]);
        $closedStatus = $this->searchStatusByCriteria->search(['id' => 3]);
        $currentStatus = $ticket->getStatusId()->getId();

        if ($currentStatus === 2) {
            $ticket->setStatusId($closedStatus);
        }

        $this->ticketRepository->add($ticket, true);
    }
}