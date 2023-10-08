<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TermeController extends AbstractController
{
    #[Route('/terme', name: 'app_terme')]
    public function index(): Response
    {
        return $this->render('terme/index.html.twig', [
            'controller_name' => 'TermeController',
        ]);
    }
}
