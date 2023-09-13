<?php

namespace App\Controller\Client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeController extends AbstractController
{
    #[Route('/demande', name: 'app_demande')]
    public function index(): Response
    {
        return $this->render('demande/index.html.twig', [
            'controller_name' => 'DemandeController',
        ]);
    }
}
