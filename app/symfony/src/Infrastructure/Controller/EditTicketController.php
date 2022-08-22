<?php

namespace App\Infrastructure\Controller;

date_default_timezone_set("Europe/Madrid");

use App\Infrastructure\Form\TicketType;
use App\Infrastructure\ORM\Doctrine\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditTicketController extends AbstractController
{
    #[Route('/admin/ticket/edit/{id}', name: 'app_ticket_edit')]
    public function EditTicket(Request $request, TicketRepository $ticketRepository): Response
    {
        $ticketID = $request->get('id');
        $ticket = $ticketRepository->findOneBy(['id' => $ticketID]);

        $priority = $ticket->getPriorityId();

        $form = $this->createForm(TicketType::class, $ticket, ['current_priority' => $priority]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket = $ticketRepository->findOneBy(['id' => $ticketID]);
            $ticket->setDescription($form->get('description')->getData());
            $ticket->setTitle($form->get('title')->getData());
            $ticket->setPriorityId($form->get('priority_id')->getData());
            $ticket->setTechnicianUserId($form->get('technician_user_id')->getData());

            $ticketRepository->add($ticket, true);

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ]);
    }
}