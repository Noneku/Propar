<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChiffreAffaireController extends AbstractController
{
    #[Route('/chiffre/affaire', name: 'app_chiffre_affaire')]
    public function index(): Response
    {
        return $this->render('chiffre_affaire/index.html.twig', [
            'controller_name' => 'ChiffreAffaireController',
        ]);
    }
}
