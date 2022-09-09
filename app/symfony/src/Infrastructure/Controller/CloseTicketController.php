<?php

namespace App\Infrastructure\Controller;

use App\Application\Update\CloseTicket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CloseTicketController extends AbstractController
{
    public function __construct(private CloseTicket $closeTicket)
    {
    }

    #[Route('/admin/close-ticket/{id}', name: 'app_ticket_close', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $ticketID = $request->get('id');
        $this->closeTicket->close($ticketID);

        return $this->redirectToRoute('app_tickets');
    }
}