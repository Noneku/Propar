<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        //Check the authentication and roles of User
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $client = $this->getUser();
        } else {
            // Si l'utilisateur n'est pas authentifié, $client est null ou non défini
            $client = null;
        }
        

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'client' => $client,
        ]);
    }
}
