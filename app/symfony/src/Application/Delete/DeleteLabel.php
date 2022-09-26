<?php

namespace App\Application\Delete;

use App\Application\Search\SearchLabelByCriteria;
use App\Domain\Repository\LabelRepositoryInterface;

class DeleteLabel
{
    public function __construct(
        private LabelRepositoryInterface $labelRepository,
        private SearchLabelByCriteria $searchLabelByCriteria
    ) {
    }

    public function delete(int $id): void
    {
        $label = $this->searchLabelByCriteria->searchOne(['id' => $id]);
        $this->labelRepository->remove($label, true);
    }
}