<?php

namespace App\Infrastructure\Controller;

use App\Application\Delete\DeleteLabel;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteLabelController extends AbstractController
{
    public function __construct(private DeleteLabel $deleteLabel)
    {
    }

    #[Route('/admin/delete-label/{id}', name: 'app_label_delete', methods: ['GET', 'DELETE'])]
    public function deleteLabel(Request $request): Response
    {
        $labelID = $request->get('id');
        $this->deleteLabel->delete($labelID);

        return $this->redirectToRoute('app_labels');
    }
}