<?php

namespace App\Infrastructure\Controller;

date_default_timezone_set("Europe/Madrid");

use App\Application\TicketCreation;
use App\Infrastructure\ORM\Doctrine\Entity\Ticket;
use App\Infrastructure\Form\TicketType;
use App\Infrastructure\ORM\Doctrine\Repository\StatusRepository;
use App\Infrastructure\ORM\Doctrine\Repository\TicketRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateTicketController extends AbstractController
{
    /*
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

            return $this->redirectToRoute('app_tickets');
        }

        return $this->render('ticket/create.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ]);
    }*/

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
            //$ticket->setCreatedDate(new DateTime());
            //$ticket->setAdminUserId($admin);
            //$ticket->setStatusId($openStatus);
            //$ticketRepository->add($ticket, true);
            new TicketCreation();
            return $this->redirectToRoute('app_tickets');
        }

        return $this->render('ticket/create.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ]);
    }
}
