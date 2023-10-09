<?php
// src/Controller/MaxOperationsReachedController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaxOperationsReachedController extends AbstractController
{
    #[Route('/max-operations-reached', name: 'max_operations_reached')]
    public function index(): Response
    {
        return $this->render('message.html.twig');
    }
}

