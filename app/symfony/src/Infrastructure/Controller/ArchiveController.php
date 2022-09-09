<?php

namespace App\Infrastructure\Controller;

date_default_timezone_set("Europe/Madrid");

use App\Application\Search\DisplayArchivedTickets;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArchiveController extends AbstractController
{
    #[Route('/archive', name: 'app_tickets_archived', methods: ['GET'])]
    public function index(DisplayArchivedTickets $displayArchivedTickets): Response
    {
        $authenticatedUser = $this->getUser();
        $tickets = $displayArchivedTickets->search($authenticatedUser);


        return $this->render('ticket/tickets.html.twig', [
            'tickets' => $tickets,
        ]);
    }
}