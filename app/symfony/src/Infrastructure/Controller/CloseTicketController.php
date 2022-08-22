<?php

namespace App\Infrastructure\Controller;

use App\Infrastructure\ORM\Doctrine\Repository\StatusRepository;
use App\Infrastructure\ORM\Doctrine\Repository\TicketRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CloseTicketController extends AbstractController
{
    #[Route('/admin/ticket/archive/{id}', name: 'app_ticket_archive')]
    public function ArchiveTicket(Request $request, TicketRepository $ticketRepository, StatusRepository $statusRepository): Response
    {
        $ticketID = $request->get('id');
        $ticket = $ticketRepository->findOneBy(['id' => $ticketID]);

        $closedStatus = $statusRepository->findOneBy(['id' => 3]);
        $currentStatus = $ticket->getStatusId()->getId();

        if ($currentStatus === 2) {
            $ticket->setStatusId($closedStatus);
            $ticket->setCompletedDate(new DateTime());
        }

        $ticketRepository->add($ticket, true);

        return $this->redirectToRoute('app_tickets');
    }
}