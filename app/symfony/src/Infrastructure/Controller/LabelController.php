<?php

namespace App\Infrastructure\Controller;

use App\Application\Create\CreateLabel;
use App\Infrastructure\Form\LabelType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LabelController extends AbstractController
{
    public function __construct(private CreateLabel $createLabel)
    {
    }


    #[Route('/admin/categories', name: 'app_categories')]
    public function index(Request $request): Response
    {
        $labelForm = $this->createForm(LabelType::class);
        $labelForm->handleRequest($request);

        if ($labelForm->isSubmitted() && $labelForm->isValid()) {
            $label = $labelForm->get('name')->getData();
            $this->createLabel->create($label);

            return $this->redirectToRoute('app_tickets');
        }

        return $this->render('dashboard/labels.html.twig', [
            'labelForm' => $labelForm->createView(),
            'errors' => $labelForm->getErrors()
        ]);
    }
}