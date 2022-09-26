<?php

namespace App\Infrastructure\Controller;

use App\Application\Search\DisplayTechnicians;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechniciansController extends AbstractController
{
    public function __construct(private DisplayTechnicians $displayTechnicians)
    {
    }

    #[Route('/admin/technicians', name: 'app_technicians', methods: ['GET'])]
    public function index(): Response
    {
        $technicians = $this->displayTechnicians->displayTechincians();

        return $this->render('user/technicians.html.twig', [
            'technicians' => $technicians,
        ]);
    }
}