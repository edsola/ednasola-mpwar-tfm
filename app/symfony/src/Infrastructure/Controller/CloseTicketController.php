<?php

namespace App\Infrastructure\Controller;

use App\Application\TicketClose;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CloseTicketController extends AbstractController
{
    public function __construct(private TicketClose $ticketClose)
    {
    }

    #[Route('/admin/close-ticket/{id}', name: 'app_ticket_close')]
    public function index(Request $request): Response
    {
        $ticketID = $request->get('id');
        $this->ticketClose->close($ticketID);

        return $this->redirectToRoute('app_tickets');
    }
}