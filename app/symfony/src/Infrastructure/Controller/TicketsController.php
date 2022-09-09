<?php

namespace App\Infrastructure\Controller;

use App\Application\Search\DisplayTicketsByFilter;
use App\Application\Search\GetPriorities;
use App\Application\Search\SearchStatusByCriteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TicketsController extends AbstractController
{
    public function __construct(
        private DisplayTicketsByFilter $displayTicketsByFilter,
        private SearchStatusByCriteria $searchStatusByCriteria,
        private GetPriorities $getPriorities
    ) {
    }

    #[Route('/', name: 'app_tickets', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $status = $request->get('status');
        $priority = $request->get('priority');
        $authenticatedUser = $this->getUser();

        $tickets = $this->displayTicketsByFilter->getTickets($status, $priority, $authenticatedUser);
        $status = $this->searchStatusByCriteria->searchAll(['id' => [1,2]]);
        $priorities = $this->getPriorities->get();


        return $this->render('ticket/tickets.html.twig', [
            'tickets' => $tickets,
            'status' => $status,
            'priority' => $priorities
        ]);
    }
}