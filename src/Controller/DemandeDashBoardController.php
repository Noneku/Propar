<?php

namespace App\Controller;


use App\Entity\Demande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\Security\Core\Security;

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
    
    // ...
    
    

    // ...
    
    public function acceptOperation(EntityManagerInterface $entityManager, $security): Response
    {
        // Récupérez l'utilisateur actuellement connecté
        $user = $security->getUser();
    
        // Récupérez le rôle de l'utilisateur
        $role = $user->getRoles()[0]; // Supposons que vous stockez le rôle dans un tableau de rôles
    
        // Déterminez le nombre maximal d'opérations acceptables en fonction du rôle
        $nombreMaxOperations = 0;
        if ($role === 'ROLE_EXPERT') {
            $nombreMaxOperations = 5;
        } elseif ($role === 'ROLE_SENIOR') {
            $nombreMaxOperations = 3;
        } elseif ($role === 'ROLE_APPRENTI') {
            $nombreMaxOperations = 1;
        }
    
        // Vérifiez le nombre d'opérations déjà acceptées par l'utilisateur
        $nombreOperationsAcceptees = $user->getNombreOperationAcceptees(); // Supposons que vous ayez cette méthode dans votre entité Utilisateur
    
        if ($nombreOperationsAcceptees >= $nombreMaxOperations) {
            // Redirigez ou affichez un message d'erreur, car l'employé a atteint sa limite d'opérations acceptables
            // Exemple de redirection :
            return $this->redirectToRoute('app_dashboard');
        }
    
        // Si tout est en ordre, acceptez l'opération ici...
    
        // Incrémentez le nombre d'opérations acceptées par l'utilisateur
        $user->setNombreOperationAcceptees($nombreOperationsAcceptees + 1);
    
        // Enregistrez les modifications dans la base de données
        $entityManager->flush();
    
        // Redirigez vers une page de confirmation ou toute autre page appropriée
        return $this->redirectToRoute('app_dashboard');
    }
    
   

// ...

// #[Route('/demande/delete/{id}', name: 'app_demande_delete')]
// public function deleteDemande(Request $request, EntityManagerInterface $entityManager, Demande $demande): RedirectResponse
// {
//     // Vérifiez si le formulaire a été soumis avec une méthode POST
//     if ($request->isMethod('POST')) {
//         // Supprimez la demande
//         $entityManager->remove($demande);
//         $entityManager->flush();
//     }

//     // Redirigez vers le tableau de bord ou toute autre page appropriée
//     return $this->redirectToRoute('app_demande_dashboard');
// }

    
}




