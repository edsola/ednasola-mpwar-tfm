<?php

namespace App\Infrastructure\Controller;

use App\Application\Search\SearchLabelByCriteria;
use App\Application\Update\UpdateLabel;
use App\Infrastructure\Form\LabelType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EditLabelController extends AbstractController
{
    public function __construct(
        private UpdateLabel $updateLabel,
        private SearchLabelByCriteria $searchLabelByCriteria
    ) {
    }

    #[Route('/admin/edit-label/{id}', name: 'app_label_edit', methods: ['GET','PUT'])]
    public function editLabel(Request $request): Response
    {
        $labelID = $request->get('id');
        $label = $this->searchLabelByCriteria->searchOne(['id' => $labelID]);

        $labelForm = $this->createForm(LabelType::class);
        $labelForm->handleRequest($request);

        if ($labelForm->isSubmitted() && $labelForm->isValid()) {
            $labelName = $labelForm->get('name')->getData();
            $this->updateLabel->update($labelName, $labelID);

            return $this->redirectToRoute('app_labels');
        }

        return $this->render('labels/edit.html.twig', [
            'label' => $label,
            'labelForm' => $labelForm->createView(),
            'errors' => $labelForm->getErrors()
        ]);
    }
}