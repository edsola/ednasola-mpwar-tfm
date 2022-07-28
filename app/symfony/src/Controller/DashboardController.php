<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(TicketRepository $ticketRepository): Response
    {
        $tickets = $ticketRepository->findBy([], ['created_date' => 'ASC']);

        return $this->render('dashboard/tickets.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    #[Route('/ticket/{id}', name: 'app_ticket')]
    public function ShowTicket(Request $request, TicketRepository $ticketRepository): Response
    {
        $ticketID = $request->get('id');
        $ticket = $ticketRepository->findOneBy(['id' => $ticketID]);

        return $this->render('dashboard/ticket.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    /*
    #[Route('/ticket/{id}', name: 'app_ticket_status')]
    public function ChangeTicketStatus(Request $request, TicketRepository $ticketRepository): Response
    {
        $ticketID = $request->get('id');
        $ticket = $ticketRepository->findOneBy(['id' => $ticketID]);
        $ticket->setStatusId()

        return $this->render('dashboard/ticket.html.twig', [
            'ticket' => $ticket,
        ]);
    }*/


}
