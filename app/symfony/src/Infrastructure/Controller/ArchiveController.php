<?php

namespace App\Infrastructure\Controller;

date_default_timezone_set("Europe/Madrid");

use App\Domain\Repository\TicketRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArchiveController extends AbstractController
{
    #[Route('/archive', name: 'app_tickets_archived')]
    public function index(TicketRepositoryInterface $ticketRepository): Response
    {
        $authenticatedUser = $this->getUser();

        if ($authenticatedUser->getRoles()[0] === 'ROLE_ADMIN') {
            $tickets = $ticketRepository->findBy(['status_id' => 3], ['created_date' => 'DESC']);
        }

        if ($authenticatedUser->getRoles()[0] === 'ROLE_TECHNICIAN') {
            $tickets = $ticketRepository->findBy(['technician_user_id' => $authenticatedUser, 'status_id' => [3]], ['created_date' => 'DESC']);
        }

        return $this->render('dashboard/tickets.html.twig', [
            'tickets' => $tickets,
        ]);
    }
}