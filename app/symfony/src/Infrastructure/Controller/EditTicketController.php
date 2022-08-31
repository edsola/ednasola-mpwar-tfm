<?php

namespace App\Infrastructure\Controller;

date_default_timezone_set("Europe/Madrid");

use App\Application\Search\GetTicketPriority;
use App\Application\Search\SearchTicketByCriteria;
use App\Application\Update\UpdateTicket;
use App\Infrastructure\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditTicketController extends AbstractController
{
    public function __construct(
        private SearchTicketByCriteria $searchTicketByCriteria,
        private GetTicketPriority $getTicketPriority,
        private UpdateTicket $updateTicket
    ) {
    }

    #[Route('/admin/edit-ticket/{id}', name: 'app_ticket_edit')]
    public function index(Request $request): Response
    {
        $ticketID = $request->get('id');
        $ticket = $this->searchTicketByCriteria->searchOne(['id' => $ticketID]);
        $priority = $this->getTicketPriority->get($ticket);

        $form = $this->createForm(TicketType::class, $ticket, ['current_priority' => $priority]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket = $this->searchTicketByCriteria->searchOne(['id' => $ticketID]);
            $title = $form->get('title')->getData();
            $description = $form->get('description')->getData();
            $priority = $form->get('priority_id')->getData();
            $technician = $form->get('technician_user_id')->getData();

            $this->updateTicket->update($ticket, $title, $description, $priority, $technician);

            return $this->redirectToRoute('app_tickets');
        }

        return $this->render('ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ]);
    }
}