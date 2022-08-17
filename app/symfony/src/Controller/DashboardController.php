<?php

namespace App\Controller;

use App\Form\TicketType;
use App\Repository\LabelRepository;
use App\Repository\PriorityRepository;
use App\Repository\StatusRepository;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;


class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function DisplayOpenAndCompletedTickets(TicketRepository $ticketRepository, StatusRepository $statusRepository, PriorityRepository $priorityRepository, LabelRepository $labelRepository, Request $request): Response
    {
        $status = $request->get('status');
        $priority = $request->get('priority');
        $authenticatedUser = $this->getUser();


        if ($authenticatedUser->getRoles()[0] === 'ROLE_ADMIN') {
            if ($status) {
                $tickets = $ticketRepository->findBy(['status_id' => $status], ['created_date' => 'DESC']);
            }
            if ($priority) {
                $tickets = $ticketRepository->findBy(['priority_id' => $priority, 'status_id' => [1,2]], ['created_date' => 'DESC']);
            }
            if (!$status && !$priority) {
                $tickets = $ticketRepository->findBy(['status_id' => [1,2]], ['created_date' => 'DESC']);
            }
        }

        if ($authenticatedUser->getRoles()[0] === 'ROLE_TECHNICIAN') {
            $tickets = $ticketRepository->findBy(['technician_user_id' => $authenticatedUser, 'status_id' => [1,2]], ['created_date' => 'DESC']);
        }

        return $this->render('dashboard/tickets.html.twig', [
            'tickets' => $tickets,
            'status' => $statusRepository->findBy(['id' => [1,2]]),
            'priority' => $priorityRepository->findAll(),
            'label' => $labelRepository->findAll()
        ]);
    }

    #[Route('/archive', name: 'app_tickets_archived')]
    public function DisplayClosedTickets(TicketRepository $ticketRepository): Response
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



    #[Route('/ticket/{id}', name: 'app_ticket')]
    public function DisplayTicket(Request $request, TicketRepository $ticketRepository): Response
    {
        $ticketID = $request->get('id');
        $ticket = $ticketRepository->findOneBy(['id' => $ticketID]);

        return $this->render('dashboard/ticket.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    #[Route('/admin/ticket/{id}', name: 'app_ticket_delete', methods: ['GET'])]
    public function DeleteTicket(Request $request, TicketRepository $ticketRepository): Response
    {
        $ticketID = $request->get('id');
        $ticket = $ticketRepository->findOneBy(['id' => $ticketID]);
        $ticketRepository->remove($ticket, true);

        return $this->redirectToRoute('app_dashboard');
    }


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


    #[Route('/ticket/status/{id}', name: 'app_ticket_status')]
    public function ChangeTicketStatus(Request $request, TicketRepository $ticketRepository, StatusRepository $statusRepository): Response
    {
        $ticketID = $request->get('id');
        $ticket = $ticketRepository->findOneBy(['id' => $ticketID]);

        $openStatus = $statusRepository->findOneBy(['id' => 1]);
        $completedStatus = $statusRepository->findOneBy(['id' => 2]);

        $currentStatus = $ticket->getStatusId()->getId();

        if ($currentStatus === 1) {
            $ticket->setStatusId($completedStatus);
        }

        if ($currentStatus === 2) {
            $ticket->setStatusId($openStatus);
        }

        $ticketRepository->add($ticket, true);

        return $this->redirectToRoute('app_dashboard');
    }

    #[Route('/admin/ticket/archive/{id}', name: 'app_ticket_archive')]
    public function ArchiveTicket(Request $request, TicketRepository $ticketRepository, StatusRepository $statusRepository): Response
    {
        $ticketID = $request->get('id');
        $ticket = $ticketRepository->findOneBy(['id' => $ticketID]);

        $closedStatus = $statusRepository->findOneBy(['id' => 3]);
        $currentStatus = $ticket->getStatusId()->getId();

        if ($currentStatus === 2) {
            $ticket->setStatusId($closedStatus);
            $ticket->setCompletedDate(new DateTime());
        }

        $ticketRepository->add($ticket, true);

        return $this->redirectToRoute('app_dashboard');
    }


}
