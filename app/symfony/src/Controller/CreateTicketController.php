<?php

namespace App\Controller;

date_default_timezone_set("Europe/Madrid");

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\StatusRepository;
use App\Repository\TicketRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateTicketController extends AbstractController
{
    #[Route('/admin/create-ticket', name: 'app_create_ticket')]
    public function index(TicketRepository $ticketRepository, Request $request, StatusRepository $statusRepository): Response
    {
        $ticket = new Ticket();

        $form = $this->createForm(TicketType::class, $ticket, ['current_priority' => $ticket->getPriorityId()]);
        $form->handleRequest($request);
        $admin = $this->getUser();
        $openStatus = $statusRepository->findOneBy(['id' => 1]);

        if($form->isSubmitted() && $form->isValid()) {
            $ticket = $form->getData();
            $ticket->setCreatedDate(new DateTime());
            $ticket->setAdminUserId($admin);
            $ticket->setStatusId($openStatus);
            $ticketRepository->add($ticket, true);

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('ticket/create.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ]);
    }
}
