<?php

namespace App\Infrastructure\Controller;

use App\Domain\Repository\StatusRepositoryInterface;
use App\Domain\Repository\TicketRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CloseTicketController extends AbstractController
{
    #[Route('/admin/close-ticket/{id}', name: 'app_ticket_archive')]
    public function ArchiveTicket(Request $request, TicketRepositoryInterface $ticketRepository, StatusRepositoryInterface $statusRepository): Response
    {
        $ticketID = $request->get('id');
        $ticket = $ticketRepository->findOneBy(['id' => $ticketID]);

        $closedStatus = $statusRepository->findOneBy(['id' => 3]);
        $currentStatus = $ticket->getStatusId()->getId();

        if ($currentStatus === 2) {
            $ticket->setStatusId($closedStatus);
        }

        $ticketRepository->add($ticket, true);

        return $this->redirectToRoute('app_tickets');
    }
}