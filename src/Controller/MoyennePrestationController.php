<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoyennePrestationController extends AbstractController
{
    #[Route('/moyenne/prestation', name: 'app_moyenne_prestation')]
    public function index(): Response
    {
        return $this->render('moyenne_prestation/index.html.twig', [
            'controller_name' => 'MoyennePrestationController',
        ]);
    }
}
