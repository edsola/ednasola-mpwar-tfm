<?php

namespace App\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct()
    {

    }

    #[Route('/account', name: 'app_account', methods: ['GET'])]
    public function account(): Response
    {
        $authenticatedUser = $this->getUser();

        return $this->render('user/account.html.twig', [
            'user' => $authenticatedUser
        ]);
    }
}