<?php

namespace App\Infrastructure\Controller;

date_default_timezone_set("Europe/Madrid");

use App\Infrastructure\ORM\Doctrine\Repository\LabelRepository;
use App\Infrastructure\ORM\Doctrine\Repository\PriorityRepository;
use App\Infrastructure\ORM\Doctrine\Repository\StatusRepository;
use App\Infrastructure\ORM\Doctrine\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TicketsController extends AbstractController
{
    #[Route('/', name: 'app_tickets')]
    public function index(TicketRepository $ticketRepository, StatusRepository $statusRepository, PriorityRepository $priorityRepository, LabelRepository $labelRepository, Request $request): Response
    {
        $status = $request->get('status');
        $priority = $request->get('priority');
        $authenticatedUser = $this->getUser();
        $tickets = [];

        $filters = [];


        if ($authenticatedUser->getRoles()[0] === 'ROLE_ADMIN') {
            if ($status) {
                //$tickets = $ticketRepository->findBy(['status_id' => $status], ['created_date' => 'DESC']);
                $filters = ['status_id' => $status];
            }
            if ($priority) {
                //$tickets += $ticketRepository->findBy(['priority_id' => $priority, 'status_id' => [1,2]], ['created_date' => 'DESC']);
                $filters += ['priority_id' => $priority, 'status_id' => [1,2]];
            }
            if (!$status && !$priority) {
                //$tickets += $ticketRepository->findBy(['status_id' => [1,2]], ['created_date' => 'DESC']);
                $filters = ['status_id' => [1,2]];
            }
            $tickets = $ticketRepository->findBy($filters, ['created_date' => 'DESC']);
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
}