<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Ticket;
use App\Domain\Entity\User;

interface TicketRepositoryInterface
{
    public function add(Ticket $entity, bool $flush = false): void;
    public function remove(Ticket $entity, bool $flush = false): void;
    public function findOpenTicketsByUser(User $user): array;
    public function findCompletedTicketsByUser(User $user): array;
}