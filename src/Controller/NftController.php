<?php

namespace App\Controller;

use App\Entity\Nft;
use App\Form\NftType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NftController extends AbstractController
{
    #[Route('/nft', name: 'app_nft')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $nft = new Nft();
        $form = $this->createForm(
            NftType::class, $nft);
            $form->handleRequest($request);
            
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($nft);
            $em->flush();
            
        }    
        return $this->render('nft/index.html.twig', [
            'nftForm' => $form->createView(),
        ]);
    }
}
