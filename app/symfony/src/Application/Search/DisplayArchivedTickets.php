<?php

namespace App\Application\Search;

use App\Domain\Entity\User;

class DisplayArchivedTickets
{
    public function __construct(
        private SearchTicketByCriteria $searchTicketByCriteria,
        private SearchStatusByCriteria $searchStatusByCriteria
    ) {
    }

    public function search(User $user): ?array
    {
        $closedStatus = $this->searchStatusByCriteria->search(['id' => 3]);

        if ($user->getRoles()[0] === 'ROLE_ADMIN') {
            $tickets = $this->searchTicketByCriteria->searchAll(['status_id' => $closedStatus], ['created_date' => 'DESC']);
        }

        if ($user->getRoles()[0] === 'ROLE_TECHNICIAN') {
            $tickets = $this->searchTicketByCriteria->searchAll(['technician_user_id' => $user, 'status_id' => [$closedStatus]], ['created_date' => 'DESC']);
        }

        return $tickets;
    }
}