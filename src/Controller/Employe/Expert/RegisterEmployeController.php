<?php

namespace App\Controller\Employe\Expert;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterEmployeController extends AbstractController
{
    #[Route('/register/employe', name: 'app_register_employe')]
    public function index(): Response
    {
        return $this->render('register_employe/index.html.twig', [
            'controller_name' => 'RegisterEmployeController',
        ]);
    }
}
