<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Label;

interface LabelRepositoryInterface
{
    public function add(Label $entity, bool $flush = false): void;
    public function remove(Label $entity, bool $flush = false): void;
}