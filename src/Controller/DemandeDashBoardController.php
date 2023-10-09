<?php

namespace App\Controller;

use App\Entity\Demande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;

class DemandeDashBoardController extends AbstractController
{
    #[Route('/demande/dashboard', name: 'app_demande_dashboard')]
    public function index(EntityManagerInterface $entityManager,
    Request $request): Response
    {
        // Récupérez la liste des demandes depuis la base de données
        $demandes = $entityManager->getRepository(Demande::class)->findAll();
         // Récupérez l'utilisateur actuellement connecté
         $user = $this->getUser();

         // Récupérez les rôles de l'utilisateur
         $role = $user->getRoles();

         //Récupérez la session
         $session = $request->getSession();

         $nombreMaxOperations = 0;
         $session->set('task', $nombreMaxOperations);
         // Vérifiez si l'utilisateur a au moins deux rôles
             if (count($role) >= 2) {
             // Accédez au deuxième rôle (index 1 dans le tableau)
            $deuxiemeRole = $role[1]; 
           
 
     // Faites quelque chose avec le deuxième rôle
             if ($deuxiemeRole === "ROLE_EXPERT") {
                 $nombreMaxOperations = 5;
             } elseif ($deuxiemeRole === "ROLE_SENIOR") {
                 $nombreMaxOperations = 3;
             } elseif ($deuxiemeRole === "ROLE_APPRENTI") {
                 $nombreMaxOperations = 1;
             }
         }
 
         
 
         // Récupérez le nombre d'opérations déjà acceptées par l'utilisateur depuis la session
         $nombreOperationsAcceptees = $session->get('NombreOperationAcceptees', 0);
 
         if ($nombreOperationsAcceptees >= $nombreMaxOperations) {
            $this->addFlash('warning', 'Vous avez atteint le nombre maximal d\'opérations acceptables.');
             return $this->redirectToRoute('app_home');
         }
 
         // Si tout est en ordre, acceptez l'opération ici...
 
         // Incrémentez le nombre d'opérations acceptées par l'utilisateur et mettez à jour la session
         $nombreOperationsAcceptees++;

         $session->set('NombreOperationAcceptees', $nombreOperationsAcceptees);

        return $this->render('demande_dashboard/index.html.twig', [
            'controller_name' => 'DemandeDashBoardController',
            'demandes' => $demandes,
        ]);
    }

    // ...

    
   
}




