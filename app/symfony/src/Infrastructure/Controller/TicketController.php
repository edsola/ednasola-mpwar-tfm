<?php

namespace App\Infrastructure\Controller;

use App\Application\Create\CreateComment;
use App\Application\Search\GetTicketComments;
use App\Application\Search\SearchTicketByCriteria;
use App\Infrastructure\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TicketController extends AbstractController
{
    public function __construct(
        private SearchTicketByCriteria $searchTicketByCriteria,
        private GetTicketComments $getTicketComments,
        private CreateComment $createComment
    ) {
    }

    #[Route('/ticket/{id}', name: 'app_ticket')]
    public function index(Request $request): Response
    {
        $ticketID = $request->get('id');
        $ticket = $this->searchTicketByCriteria->searchOne(['id' => $ticketID]);
        $comments = $this->getTicketComments->get($ticket);
        $authenticatedUser = $this->getUser();

        $commentForm = $this->createForm(CommentType::class);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment = $commentForm->getData();
            $this->createComment->create($comment, $authenticatedUser, $ticket);
        }

        return $this->render('ticket/ticket.html.twig', [
            'ticket' => $ticket,
            'comments' => $comments,
            'commentForm' => $commentForm->createView(),
            'errors' => $commentForm->getErrors()
        ]);
    }
}