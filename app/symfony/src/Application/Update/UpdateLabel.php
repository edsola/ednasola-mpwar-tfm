<?php

namespace App\Application\Update;

use App\Domain\Repository\LabelRepositoryInterface;

class UpdateLabel
{
    public function __construct(private LabelRepositoryInterface $labelRepository)
    {
    }

    public function update(string $name, int $id): void
    {
        $label = $this->labelRepository->findOneBy(['id' => $id]);
        $label->setName($name);

        $this->labelRepository->add($label, true);
    }
}