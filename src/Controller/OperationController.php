<?php

namespace App\Controller;

use App\Entity\Operation;
use App\Form\OperationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


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

    #[Route('/operation/{id}/edit', name: 'app_operation_edit')]
    #[Security('is_granted("ROLE_EXPERT")')] //autorise uniquement l'expert
    public function edit(EntityManagerInterface $entityManager, Operation $operation, Request $request): Response
    {
       
        // Créez un formulaire pour la modification de l'employé (vous devez créer ce formulaire)
        $form = $this->createForm(OperationType::class, $operation);
        
        // Gérez la soumission du formulaire et mettez à jour l'employé
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Vous n'avez pas besoin de récupérer l'ID et le matricule ici, car $operation contient déjà ces informations
            // Par exemple, vous pouvez accéder à l'ID avec $operation->getId() et au matricule avec $operation->getEmploye()->getMatricule()

            // Enregistrez les modifications dans la base de données
            $entityManager->flush();

            // Redirigez l'utilisateur vers la page de tableau de bord ou une autre page appropriée
            return $this->redirectToRoute('app_operation', [], Response::HTTP_SEE_OTHER);
        }

        // Affichez le formulaire pour la modification de l'employé
        return $this->render('operation/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/operation/finish/{id}', name: 'app_operation_finish')]
    public function finishOperation(EntityManagerInterface $entityManager, Operation $operation): Response
    {
        // Appelez la méthode finish() pour marquer l'opération comme terminée
        $operation->finish();
        
        // Enregistrez les modifications dans la base de données
        $entityManager->flush();
        
        // Répondez avec une réponse JSON ou une réponse appropriée
        return $this->json(['success' => false]);
    }
}
