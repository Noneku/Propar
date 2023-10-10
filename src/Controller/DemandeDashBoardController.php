<?php

namespace App\Controller;

use App\Entity\Demande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class DemandeDashBoardController extends AbstractController
{
    #[Route('/demande/dashboard', name: 'app_demande_dashboard')]
    public function index(
        EntityManagerInterface $entityManager,
        SessionInterface $session,

    ): Response {
        // Récupérez la liste des demandes depuis la base de données
        $demandes = $entityManager->getRepository(Demande::class)->findAll();

        // Récupérez l'utilisateur actuellement connecté
        // $user = $this->getUser();

        // // Récupérez les rôles de l'utilisateur
        // $role = $user->getRoles();

        // Vérifiez si l'utilisateur a au moins deux rôles
        // if (count($role) >= 2) {
        //     // Accédez au deuxième rôle (index 1 dans le tableau)
        //     $deuxiemeRole = $role[1];

        //     // // Faites quelque chose avec le deuxième rôle
        //     // if ($deuxiemeRole === "ROLE_EXPERT") {
        //     //     $nombreMaxOperations = 5;
        //     // } elseif ($deuxiemeRole === "ROLE_SENIOR") {
        //     //     $nombreMaxOperations = 3;
        //     // } elseif ($deuxiemeRole === "ROLE_APPRENTI") {
        //     //     $nombreMaxOperations = 1;
        //     }
        // }       
        // Récupérez le nombre d'opérations déjà acceptées par l'utilisateur depuis la session

        // if ($nombreOperationsAcceptees >= $nombreMaxOperations) {
        //     //renvoi vers une page précisant que l'utilisateur a atteint le max d'opération qu'il peut gerer
        //     return $this->redirectToRoute('max_operations_reached');
        // }

        // Incrémentez le nombre d'opérations acceptées par l'utilisateur et mettez à jour la session

        return $this->render('demande_dashboard/index.html.twig', [
            'controller_name' => 'DemandeDashBoardController',
            'demandes' => $demandes,
        ]);
    }


}





