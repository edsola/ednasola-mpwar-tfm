<?php

namespace App\Infrastructure\Controller;

use App\Infrastructure\ORM\Doctrine\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechniciansController extends AbstractController
{
    #[Route('/admin/technicians', name: 'app_technicians')]
    public function index(UserRepository $userRepository): Response
    {

        $technicians = $userRepository->findByRole('ROLE_TECHNICIAN');
        //$technicians = $userRepository->findAll();

        //Agafar els usuaris tècnics
        //Per cada usuari, agafar els tickets oberts



        return $this->render('dashboard/technicians.html.twig', [
            'technicians' => $technicians,
        ]);
    }
}