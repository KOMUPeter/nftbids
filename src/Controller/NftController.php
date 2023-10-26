<?php
namespace App\Controller;

use App\Entity\Nft;
use App\Entity\User;
use App\Form\NftType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NftController extends AbstractController
{
    #[Route('/nft', name: 'app_nft')]
    // public function index(Request $request, EntityManagerInterface $em): Response
    // {
    //     $nft = new Nft();
    //     /** @var \App\Entity\User $user */
    //     $user = $this->getUser();
    //     $nft->setNftOwner($user);

    //     $form = $this->createForm(NftType::class, $nft);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $em->persist($nft);
    //         $em->flush();

    //         return $this->redirectToRoute('app_user', [
    //             'id' => $user->getId(),
    //         ]);
    //     }
    //     return $this->render('nft/index.html.twig', [
    //         'nftForm' => $form->createView(),
    //     ]);
    // }



    public function index(Request $request, EntityManagerInterface $em, Security $security): Response
    {
        $nft = new Nft();
        
        $user = $security->getUser();
        $form = $this->createForm(NftType::class, $nft); // Define the form initially

        if ($user instanceof User) {
            $nft->setNftOwner($user);

            $form->handleRequest($request); // Update the form inside the conditional block

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($nft);
                $em->flush();

                return $this->redirectToRoute('app_user', [
                    'id' => $user->getId(),
                ]);
            }
        }
        
        return $this->render('nft/index.html.twig', [
            'nftForm' => $form->createView(),
        ]);
    }
}