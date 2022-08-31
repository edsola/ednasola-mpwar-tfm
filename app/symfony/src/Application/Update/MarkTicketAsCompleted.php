<?php

namespace App\Application\Update;

date_default_timezone_set("Europe/Madrid");

use App\Application\Search\SearchStatusByCriteria;
use App\Application\Search\SearchTicketByCriteria;
use App\Domain\Repository\TicketRepositoryInterface;
use DateTime;

class MarkTicketAsCompleted
{
    public function __construct(
        private SearchTicketByCriteria $searchTicketByCriteria,
        private SearchStatusByCriteria $searchStatusByCriteria,
        private TicketRepositoryInterface $ticketRepository
    ) {
    }

    public function changeStatus(int $id): void
    {
        $ticket = $this->searchTicketByCriteria->searchOne(['id' => $id]);
        $openStatus = $this->searchStatusByCriteria->search(['id' => 1]);
        $completedStatus = $this->searchStatusByCriteria->search(['id' => 2]);
        $currentStatus = $ticket->getStatusId()->getId();

        if ($currentStatus === 1) {
            $ticket->setStatusId($completedStatus);
        }

        if ($currentStatus === 2) {
            $ticket->setStatusId($openStatus);
            $ticket->setCompletedDate(new DateTime());
        }

        $this->ticketRepository->add($ticket, true);
    }
}