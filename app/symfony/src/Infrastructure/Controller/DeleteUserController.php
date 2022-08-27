<?php

namespace App\Infrastructure\Controller;

use App\Domain\Repository\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteUserController extends AbstractController
{
    #[Route('/admin/delete-user/{id}', name: 'app_user_delete', methods: ['GET'])]
    public function DeleteUser(Request $request, UserRepositoryInterface $userRepository): Response
    {
        //Fer que els openn siguin eeliminats o reassignats
        //I eels completeds???

        $userID = $request->get('id');
        $user = $userRepository->findOneBy(['id' => $userID]);
        $userRepository->remove($user, true);

        return $this->redirectToRoute('app_technicians');
    }
}