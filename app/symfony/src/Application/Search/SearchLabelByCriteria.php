<?php

namespace App\Application\Search;

use App\Domain\Entity\Label;
use App\Domain\Exception\NotValidLabel;
use App\Domain\Exception\NotValidTicket;
use App\Domain\Repository\LabelRepositoryInterface;

class SearchLabelByCriteria
{
    public function __construct(private LabelRepositoryInterface $labelRepository)
    {
    }

    public function searchOne(array $criteria, array $orderBy = null): ?Label
    {
        $label = $this->labelRepository->findOneBy($criteria, $orderBy);

        if ($label === null) {
            throw new NotValidLabel();
        }

        return $label;
    }

    public function searchAll(array $criteria, array $orderBy = null): ?Label
    {
        return $this->labelRepository->findOneBy($criteria, $orderBy);
    }
}