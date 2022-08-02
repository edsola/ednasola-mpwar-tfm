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
        $authenticatedUser = $this->getUser();

        if ($authenticatedUser->getRoles()[0] === 'ROLE_ADMIN') {
            $tickets = $ticketRepository->findBy([], ['created_date' => 'DESC']);
        }

        if ($authenticatedUser->getRoles()[0] === 'ROLE_TECHNICIAN') {
            $tickets = $ticketRepository->findBy(['technician_user_id' => $authenticatedUser], ['created_date' => 'DESC']);
        }

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

    #[Route('/admin/ticket/{id}', name: 'app_ticket_delete', methods: ['GET'])]
    public function DeleteTicket(Request $request, TicketRepository $ticketRepository): Response
    {
        $ticketID = $request->get('id');
        $ticket = $ticketRepository->findOneBy(['id' => $ticketID]);
        $ticketRepository->remove($ticket, true);

        return $this->redirectToRoute('app_home');
    }


}
