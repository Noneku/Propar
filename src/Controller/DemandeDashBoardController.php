<?php

namespace App\Controller;


use App\Entity\Demande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemandeDashBoardController extends AbstractController
{
    #[Route('/demande/dashboard', name: 'app_demande_dashboard')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $demandes = $entityManager->getRepository(Demande::class)->findAll();

        return $this->render('demande_dashboard/index.html.twig', [
            'controller_name' => 'DemandeDashBoardController',
            'demandes' => $demandes,
        ]);
    }
}
