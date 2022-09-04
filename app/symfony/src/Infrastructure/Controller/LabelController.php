<?php

namespace App\Infrastructure\Controller;

use App\Application\Create\CreateLabel;
use App\Application\Delete\DeleteLabel;
use App\Application\Search\GetLabels;
use App\Application\Search\SearchLabelByCriteria;
use App\Application\Update\UpdateLabel;
use App\Infrastructure\Form\LabelType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LabelController extends AbstractController
{
    public function __construct(
        private CreateLabel $createLabel,
        private GetLabels $getLabels,
        private UpdateLabel $updateLabel,
        private SearchLabelByCriteria $searchLabelByCriteria,
        private DeleteLabel $deleteLabel
    ) {
    }

    #[Route('/admin/labels', name: 'app_labels')]
    public function index(Request $request): Response
    {
        $labels = $this->getLabels->get();

        $labelForm = $this->createForm(LabelType::class);
        $labelForm->handleRequest($request);

        if ($labelForm->isSubmitted() && $labelForm->isValid()) {
            $label = $labelForm->get('name')->getData();
            $this->createLabel->create($label);

            return $this->redirectToRoute('app_labels');
        }

        return $this->render('labels/labels.html.twig', [
            'labels' => $labels,
            'labelForm' => $labelForm->createView(),
            'errors' => $labelForm->getErrors()
        ]);
    }



    #[Route('/admin/edit-label/{id}', name: 'app_label_edit')]
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


    #[Route('/admin/delete-label/{id}', name: 'app_label_delete')]
    public function deleteLabel(Request $request): Response
    {
        $labelID = $request->get('id');
        $this->deleteLabel->delete($labelID);

        return $this->redirectToRoute('app_labels');
    }
}