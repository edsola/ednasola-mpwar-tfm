<?php

namespace App\Infrastructure\Controller;

use App\Infrastructure\ORM\Doctrine\Repository\TicketRepository;
use App\Infrastructure\ORM\Doctrine\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TechniciansController extends AbstractController
{
    #[Route('/admin/technicians', name: 'app_technicians')]
    public function index(UserRepository $userRepository, TicketRepository $ticketRepository, SerializerInterface $serializer): Response
    {
        $technicians = $userRepository->findByRole('ROLE_TECHNICIAN');
        $techniciansResult = [];
        $averageTime = '';

        foreach ($technicians as $technician) {
            $openTickets = $ticketRepository->findOpenTicketsByUser($technician);
            $completedTickets = $ticketRepository->findCompletedTicketsByUser($technician);

            if ($completedTickets) {
                $averageTime = $this->calculateTicketsAverageTime($completedTickets);
            }

            if (!$completedTickets) {
                $averageTime = '-';
            }

            $user = [
                'name' => $technician->getName() . ' ' . $technician->getSurname(),
                'email' => $technician->getEmail(),
                'openTickets' => $openTickets,
                'completedTickets' => $completedTickets,
                'averageTime' => $averageTime
            ];

            $techniciansResult[] = $user;
        }

        return $this->render('dashboard/technicians.html.twig', [
            'technicians' => $techniciansResult,
        ]);
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