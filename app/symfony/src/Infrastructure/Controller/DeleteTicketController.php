<?php

namespace App\Infrastructure\Controller;

use App\Infrastructure\ORM\Doctrine\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DeleteTicketController extends AbstractController
{
    #[Route('/admin/ticket/{id}', name: 'app_ticket_delete', methods: ['GET'])]
    public function DeleteTicket(Request $request, TicketRepository $ticketRepository): Response
    {
        $ticketID = $request->get('id');
        $ticket = $ticketRepository->findOneBy(['id' => $ticketID]);
        $ticketRepository->remove($ticket, true);

        return $this->redirectToRoute('app_dashboard');
    }
}