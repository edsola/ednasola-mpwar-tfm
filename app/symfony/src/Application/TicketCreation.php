<?php

namespace App\Application;

use App\Domain\Entity\Priority;
use App\Domain\Entity\Status;
use App\Domain\Entity\Ticket;
use App\Domain\Entity\User;
use App\Domain\Repository\TicketRepositoryInterface;
use Cassandra\Uuid;

class TicketCreation
{
    public function __construct(private TicketRepositoryInterface $ticketRepository)
    {
    }

    public function __invoke(int $id, string $title, string $description, \DateTimeInterface $created_date, \DateTimeInterface $completed_date, User $technician_user, Priority $priority, Status $status, array $labels, User $admin_user, array $comments)
    {
        $ticket = Ticket::CreateTicket($id, $title, $description, $created_date, $completed_date, $technician_user, $priority, $status, $labels, $admin_user, $comments);
        $this->ticketRepository->add($ticket);
    }
}