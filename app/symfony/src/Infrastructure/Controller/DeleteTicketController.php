<?php

namespace App\Infrastructure\Controller;

use App\Application\Delete\DeleteTicket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DeleteTicketController extends AbstractController
{
    public function __construct(private DeleteTicket $deleteTicket)
    {
    }

    #[Route('/admin/delete-ticket/{id}', name: 'app_ticket_delete', methods: ['GET', 'DELETE'])]
    public function index(Request $request): Response
    {
        $ticketID = $request->get('id');
        $this->deleteTicket->delete($ticketID);

        return $this->redirectToRoute('app_tickets');
    }
}