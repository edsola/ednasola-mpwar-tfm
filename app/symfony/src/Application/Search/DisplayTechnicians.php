<?php

namespace App\Application\Search;

use App\Domain\Repository\TicketRepositoryInterface;
use App\Domain\Repository\UserRepositoryInterface;

class DisplayTechnicians
{
    public function __construct(
        private TicketRepositoryInterface $ticketRepository,
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function displayTechincians(): ?array
    {
        $technicians = $this->userRepository->findByRole('ROLE_TECHNICIAN');
        $techniciansResult = [];
        $averageTime = '';

        foreach ($technicians as $technician) {
            $openTickets = $this->ticketRepository->findOpenTicketsByUser($technician);
            $completedTickets = $this->ticketRepository->findCompletedTicketsByUser($technician);

            if ($completedTickets) {
                $averageTime = $this->calculateTicketsAverageTime($completedTickets);
            }

            if (!$completedTickets) {
                $averageTime = '-';
            }

            $user = [
                'id' => $technician->getID(),
                'name' => $technician->getName() . ' ' . $technician->getSurname(),
                'email' => $technician->getEmail(),
                'openTickets' => $openTickets,
                'completedTickets' => $completedTickets,
                'averageTime' => $averageTime
            ];

            $techniciansResult[] = $user;
        }

        return $techniciansResult;
    }

    public function calculateTicketsAverageTime($tickets): string
    {
        $totalSeconds = 0;
        $totalTickets = count($tickets);

        foreach ($tickets as $ticket) {
            $createdDate = $ticket->getCreatedDate();
            $completedDate = $ticket->getCompletedDate();

            $dateDiff = date_diff($createdDate, $completedDate);
            $seconds = $dateDiff->s
                + (strtotime($dateDiff->m . 'months', 0))
                + (strtotime($dateDiff->d . 'days', 0))
                + (strtotime($dateDiff->h . 'hours', 0))
                + (strtotime($dateDiff->i . 'minutes', 0));

            $totalSeconds += $seconds;
        }

        $averageSeconds = $totalSeconds / $totalTickets;

        return $this->secondsToDaysHoursMinutes($averageSeconds);
    }


    public function secondsToDaysHoursMinutes($seconds): string
    {
        $result = '';
        $days = intval($seconds / (3600 * 24));
        $hours = (intval($seconds) / 3600) % 24;
        $minutes = (intval($seconds) / 60) % 60;

        if ($days) {
            $result = $days . 'd ';
        }
        if ($hours) {
            $result .= $hours . 'h ';
        }
        $result .= $minutes . 'm';

        return $result;
    }
}