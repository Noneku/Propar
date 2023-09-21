<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GrossePrestationController extends AbstractController
{
    #[Route('/grosse/prestation', name: 'app_grosse_prestation')]
    public function index(): Response
    {
        return $this->render('grosse_prestation/index.html.twig', [
            'controller_name' => 'GrossePrestationController',
        ]);
    }
}
