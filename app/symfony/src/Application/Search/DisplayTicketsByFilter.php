<?php

namespace App\Application\Search;

use App\Domain\Entity\User;
use App\Domain\Repository\TicketRepositoryInterface;

class DisplayTicketsByFilter
{
    public function __construct(private TicketRepositoryInterface $ticketRepository)
    {
    }

    public function getTickets(?string $status, ?string $priority, User $user): array
    {
        $tickets = [];

        if ($user->getRoles()[0] === 'ROLE_ADMIN') {
            if ($status) {
                $tickets = $this->ticketRepository->findBy(['status_id' => $status], ['created_date' => 'DESC']);
            }
            if ($priority) {
                $tickets += $this->ticketRepository->findBy(
                    ['priority_id' => $priority, 'status_id' => [1, 2]],
                    ['created_date' => 'DESC']
                );
            }
            if (!$status && !$priority) {
                $tickets += $this->ticketRepository->findBy(['status_id' => [1, 2]], ['created_date' => 'DESC']);
            }
        }

        if ($user->getRoles()[0] === 'ROLE_TECHNICIAN') {
            if ($status) {
                $tickets = $this->ticketRepository->findBy(
                    ['technician_user_id' => $user, 'status_id' => $status],
                    ['created_date' => 'DESC']
                );
            }
            if ($priority) {
                $tickets = $this->ticketRepository->findBy(
                    ['technician_user_id' => $user, 'priority_id' => $priority, 'status_id' => [1, 2]],
                    ['created_date' => 'DESC']
                );
            }
            if (!$status && !$priority) {
                $tickets = $this->ticketRepository->findBy(
                    ['technician_user_id' => $user, 'status_id' => [1, 2]],
                    ['created_date' => 'DESC']
                );
            }
        }

        return $tickets;
    }
}