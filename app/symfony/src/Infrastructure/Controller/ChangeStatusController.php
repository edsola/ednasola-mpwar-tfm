<?php

namespace App\Infrastructure\Controller;

use App\Domain\Repository\StatusRepositoryInterface;
use App\Domain\Repository\TicketRepositoryInterface;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChangeStatusController extends AbstractController
{
    #[Route('/change-status/{id}', name: 'app_ticket_status')]
    public function ChangeTicketStatus(Request $request, TicketRepositoryInterface $ticketRepository, StatusRepositoryInterface $statusRepository): Response
    {
        $ticketID = $request->get('id');
        $ticket = $ticketRepository->findOneBy(['id' => $ticketID]);

        $openStatus = $statusRepository->findOneBy(['id' => 1]);
        $completedStatus = $statusRepository->findOneBy(['id' => 2]);

        $currentStatus = $ticket->getStatusId()->getId();

        if ($currentStatus === 1) {
            $ticket->setStatusId($completedStatus);
        }

        if ($currentStatus === 2) {
            $ticket->setStatusId($openStatus);
            $ticket->setCompletedDate(new DateTime());
        }

        $ticketRepository->add($ticket, true);

        return $this->redirectToRoute('app_tickets');
    }
}