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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        //If granted User is Stored in $client
        $client = $this->getUser();
        

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'client' => $client,
        ]);
    }
}
