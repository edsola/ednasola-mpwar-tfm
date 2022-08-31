<?php

namespace App\Infrastructure\Controller;

use App\Application\Update\MarkTicketAsCompleted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChangeStatusController extends AbstractController
{
    public function __construct(private MarkTicketAsCompleted $markTicketAsCompleted)
    {
    }

    #[Route('/change-status/{id}', name: 'app_ticket_status')]
    public function index(Request $request): Response
    {
        $ticketID = $request->get('id');
        $this->markTicketAsCompleted->changeStatus($ticketID);

        return $this->redirectToRoute('app_tickets');
    }
}