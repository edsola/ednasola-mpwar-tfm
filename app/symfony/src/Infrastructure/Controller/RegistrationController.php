<?php

namespace App\Infrastructure\Controller;

use App\Application\Create\CreateEmptyUser;
use App\Application\Create\CreateUser;
use App\Infrastructure\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    public function __construct(private CreateEmptyUser $createEmptyUser, private CreateUser $createUser)
    {
    }

    #[Route('/admin/register', name: 'app_register')]
    public function register(Request $request): Response
    {
        $user = $this->createEmptyUser->create();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $plainPassword = $form->get('plainPassword')->getData();
            $this->createUser->create($user, $plainPassword);

            return $this->redirectToRoute('app_tickets');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'errors' => $form->getErrors()
        ]);
    }
}



/*$email = $form->get('email')->getData();
$name = $form->get('name')->getData();
$surname = $form->get('surname')->getData();
$plainPassword = $form->get('plainPassword')->getData();
$role = $form->get('roles')->getData();*/
//$this->createUser->create($email, $name, $surname, $plainPassword, $role);
