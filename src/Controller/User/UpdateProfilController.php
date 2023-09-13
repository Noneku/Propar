<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateProfilController extends AbstractController
{
    #[Route('/update/profil', name: 'app_update_profil')]
    public function index(): Response
    {
        return $this->render('update_profil/index.html.twig', [
            'controller_name' => 'UpdateProfilController',
        ]);
    }
}
