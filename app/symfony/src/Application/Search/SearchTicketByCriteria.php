<?php

namespace App\Application\Search;

use App\Domain\Entity\Ticket;
use App\Domain\Repository\TicketRepositoryInterface;

class SearchTicketByCriteria
{
    public function __construct(private TicketRepositoryInterface $ticketRepository)
    {
    }

    public function searchOne(array $criteria, array $orderBy = null): ?Ticket
    {
       return $this->ticketRepository->findOneBy($criteria, $orderBy);
    }

    public function searchAll(array $criteria, array $orderBy = null): array
    {
        return $this->ticketRepository->findBy($criteria, $orderBy);
    }
}