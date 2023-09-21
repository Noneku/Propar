<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PetitePrestationController extends AbstractController
{
    #[Route('/petite/prestation', name: 'app_petite_prestation')]
    public function index(): Response
    {
        return $this->render('petite_prestation/index.html.twig', [
            'controller_name' => 'PetitePrestationController',
        ]);
    }
}
