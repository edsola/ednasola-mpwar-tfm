<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Ticket;

interface TicketRepositoryInterface
{
    public function add(Ticket $entity, bool $flush = false): void;
    public function remove(Ticket $entity, bool $flush = false): void;
}