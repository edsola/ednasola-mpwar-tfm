<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
