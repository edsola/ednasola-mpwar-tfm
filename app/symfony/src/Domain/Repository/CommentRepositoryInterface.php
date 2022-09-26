<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Comment;

interface CommentRepositoryInterface
{
    public function add(Comment $entity, bool $flush = false): void;
    public function remove(Comment $entity, bool $flush = false): void;
}