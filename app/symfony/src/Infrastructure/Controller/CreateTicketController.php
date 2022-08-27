<?php

namespace App\Infrastructure\Controller;

use App\Application\TicketCreation;
use App\Application\TicketEmptyCreation;
use App\Infrastructure\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateTicketController extends AbstractController
{
    public function __construct(private TicketCreation $ticketCreation, private TicketEmptyCreation $ticketEmptyCreation)
    {
    }

    #[Route('/admin/create-ticket', name: 'app_ticket_create')]
    public function index(Request $request): Response
    {
        $ticket = $this->ticketEmptyCreation->create();
        $admin = $this->getUser();

        $form = $this->createForm(TicketType::class, $ticket, ['current_priority' => $ticket->getPriorityId()]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $ticket = $form->getData();
            $this->ticketCreation->create($ticket, $admin);

            return $this->redirectToRoute('app_tickets');
        }

        return $this->render('ticket/create.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ]);
    }
}
