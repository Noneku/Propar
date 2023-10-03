<?php

namespace App\Controller;

use App\Entity\Operation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OperationController extends AbstractController
{
    #[Route('/operation', name: 'app_operation')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $operations = $entityManager->getRepository(Operation::class)->findAll();

        return $this->render('operation/index.html.twig', [
            'controller_name' => 'OperationController',
            'operations' => $operations,
        ]);
    }
}
