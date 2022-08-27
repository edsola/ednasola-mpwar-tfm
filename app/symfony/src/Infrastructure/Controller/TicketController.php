<?php

namespace App\Infrastructure\Controller;

date_default_timezone_set("Europe/Madrid");

use App\Domain\Repository\CommentRepositoryInterface;
use App\Domain\Repository\TicketRepositoryInterface;
use App\Infrastructure\Form\CommentType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TicketController extends AbstractController
{
    #[Route('/ticket/{id}', name: 'app_ticket')]
    public function index(Request $request, TicketRepositoryInterface $ticketRepository, CommentRepositoryInterface $commentRepository): Response
    {
        $ticketID = $request->get('id');
        $ticket = $ticketRepository->findOneBy(['id' => $ticketID]);
        $comments = $ticket->getComments();
        $authenticatedUser = $this->getUser();

        $commentForm = $this->createForm(CommentType::class);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment = $commentForm->getData();
            $comment->setDate(new DateTime());
            $comment->setUser($authenticatedUser);
            $comment->setTicket($ticket);

            $commentRepository->add($comment, true);
        }

        return $this->render('dashboard/ticket.html.twig', [
            'ticket' => $ticket,
            'comments' => $comments,
            'commentForm' => $commentForm->createView(),
            'errors' => $commentForm->getErrors()
        ]);
    }
}