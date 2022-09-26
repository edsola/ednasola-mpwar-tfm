<?php

namespace App\Application\Delete;

use App\Application\Search\SearchTicketByCriteria;
use App\Domain\Repository\TicketRepositoryInterface;

class DeleteTicket
{
    public function __construct(
        private TicketRepositoryInterface $ticketRepository,
        private SearchTicketByCriteria $searchTicketByCriteria
    ) {
    }

    public function delete(int $id): void
    {
        $ticket = $this->searchTicketByCriteria->searchOne(['id' => $id]);
        $this->ticketRepository->remove($ticket, true);
    }
}