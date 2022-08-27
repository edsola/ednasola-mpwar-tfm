<?php

namespace App\Application;

use App\Domain\Repository\TicketRepositoryInterface;

class TicketClose
{
    public function __construct(
        private TicketSearchByCriteria $ticketSearchByCriteria,
        private StatusSearchByCriteria $statusSearchByCriteria,
        private TicketRepositoryInterface $ticketRepository
    ) {
    }

    public function close(int $id): void
    {
        $ticket = $this->ticketSearchByCriteria->searchOne(['id' => $id]);
        $closedStatus = $this->statusSearchByCriteria->search(['id' => 3]);
        $currentStatus = $ticket->getStatusId()->getId();

        if ($currentStatus === 2) {
            $ticket->setStatusId($closedStatus);
        }

        $this->ticketRepository->add($ticket, true);
    }
}