<?php

namespace App\Controller;

use App\Entity\Nft;
use App\Repository\NftRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @return Nft[] Returns an array of Anoucement objects
     */

class HomeController extends AbstractController
{
    #[Route('/', name: 'homePage')]
    public function index(NftRepository $nftRepository): Response
    {
        $nfts = $nftRepository->nftList();
        // dd($nfts);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            "nfts" =>  $nfts,
        ]);
    }
}