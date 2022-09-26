<?php

namespace App\Application\Create;

use App\Domain\Entity\Label;
use App\Domain\Repository\LabelRepositoryInterface;

class CreateLabel
{
    public function __construct(private LabelRepositoryInterface $labelRepository)
    {
    }

    public function create(string $name): void
    {
        $label = new Label();
        $label->setName($name);
        $this->labelRepository->add($label, true);
    }
}