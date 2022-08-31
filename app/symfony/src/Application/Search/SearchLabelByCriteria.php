<?php

namespace App\Application\Search;

use App\Domain\Entity\Label;
use App\Domain\Repository\LabelRepositoryInterface;

class SearchLabelByCriteria
{
    public function __construct(private LabelRepositoryInterface $labelRepository)
    {
    }

    public function searchOne(array $criteria, array $orderBy = null): ?Label
    {
        return $this->labelRepository->findOneBy($criteria, $orderBy);
    }

    public function searchAll(array $criteria, array $orderBy = null): ?Label
    {
        return $this->labelRepository->findOneBy($criteria, $orderBy);
    }
}