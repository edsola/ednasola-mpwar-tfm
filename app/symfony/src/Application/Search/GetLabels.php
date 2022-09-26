<?php

namespace App\Application\Search;

use App\Domain\Repository\LabelRepositoryInterface;

class GetLabels
{
    public function __construct(private LabelRepositoryInterface $labelRepository)
    {
    }

    public function get(): array
    {
        $labels = $this->labelRepository->findAll();
        return $labels;
    }
}