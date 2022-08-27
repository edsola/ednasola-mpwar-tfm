<?php

namespace App\Infrastructure\Controller;

use App\Domain\Repository\TicketRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DeleteTicketController extends AbstractController
{
    #[Route('/admin/delete-ticket/{id}', name: 'app_ticket_delete', methods: ['GET'])]
    public function DeleteTicket(Request $request, TicketRepositoryInterface $ticketRepository): Response
    {
        $ticketID = $request->get('id');
        $ticket = $ticketRepository->findOneBy(['id' => $ticketID]);
        $ticketRepository->remove($ticket, true);

        return $this->redirectToRoute('app_tickets');
    }
}