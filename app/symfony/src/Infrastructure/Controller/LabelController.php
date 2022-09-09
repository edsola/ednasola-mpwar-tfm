<?php

namespace App\Infrastructure\Controller;

use App\Application\Create\CreateLabel;
use App\Application\Search\GetLabels;
use App\Infrastructure\Form\LabelType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LabelController extends AbstractController
{
    public function __construct(
        private CreateLabel $createLabel,
        private GetLabels $getLabels
    ) {
    }

    #[Route('/admin/labels', name: 'app_labels', methods: ['GET', 'POST'])]
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
}