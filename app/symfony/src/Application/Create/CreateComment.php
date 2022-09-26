<?php

namespace App\Application\Create;

date_default_timezone_set("Europe/Madrid");

use App\Domain\Entity\Comment;
use App\Domain\Entity\Ticket;
use App\Domain\Entity\User;
use App\Domain\Repository\CommentRepositoryInterface;
use DateTime;

class CreateComment
{
    public function __construct(private CommentRepositoryInterface $commentRepository)
    {
    }

    public function create(Comment $comment, User $user, Ticket $ticket): void
    {
        $comment->setDate(new DateTime());
        $comment->setUser($user);
        $comment->setTicket($ticket);

        $this->commentRepository->add($comment, true);
    }
}