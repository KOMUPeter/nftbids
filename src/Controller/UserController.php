<?php

namespace App\Controller;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/{id}', name: 'app_user', requirements: ['id' => "\d+"])]
    public function fetchUser(
        int $id,
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
    ): Response {
        $user = $userRepository->find($id);

        if ($user) {
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // On récupère les données du formulaire
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success', 'data inserted');

                return $this->redirectToRoute('app_user');
            }

        } else {
            throw $this->createNotFoundException('User does not exist, find another id');
        }
        // dd($user);
        // Use the $user object as needed
        return $this->render('user/index.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}