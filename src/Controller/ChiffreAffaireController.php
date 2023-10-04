<?php

namespace App\Controller;

use App\Entity\Operation;
use App\Form\Operation1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/chiffre/affaire')]
class ChiffreAffaireController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_chiffre_affaire_index', methods: ['GET'])]
    public function index(): Response
    {
        // Récupérer toutes les opérations avec les demandes et les prestations associées
        $operations = $this->entityManager
            ->createQueryBuilder()
            ->select('o, d, p')
            ->from(Operation::class, 'o')
            ->leftJoin('o.demande', 'd')
            ->leftJoin('d.prestation', 'p')
            ->getQuery()
            ->getResult();

        // Rendre le template 'chiffre_affaire/index.html.twig' avec les données récupérées
        return $this->render('chiffre_affaire/index.html.twig', [
            'operations' => $operations,
            
        ]);

        
    }



// Action pour afficher les détails d'une opération spécifique
#[Route('/{id}', name: 'app_chiffre_affaire_show', methods: ['GET'])]
public function show(Operation $operation): Response
{
    // Rendre le template 'chiffre_affaire/show.html.twig' avec l'opération spécifiée
    return $this->render('chiffre_affaire/show.html.twig', [
        'operation' => $operation,
    ]);
}

// Action pour afficher le formulaire de modification d'une opération existante
#[Route('/{id}/edit', name: 'app_chiffre_affaire_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Operation $operation): Response
{
    // Créer un formulaire de modification basé sur le type Operation1Type et associer l'opération existante
    $form = $this->createForm(Operation1Type::class, $operation);
    // Gérer la soumission du formulaire
    $form->handleRequest($request);

    // Vérifier si le formulaire est soumis et valide
    if ($form->isSubmitted() && $form->isValid()) {
        // Mettre à jour l'opération dans la base de données
        $this->entityManager->flush();

        // Rediriger l'utilisateur vers la liste des opérations
        return $this->redirectToRoute('app_chiffre_affaire_index', [], Response::HTTP_SEE_OTHER);
    }

    // Rendre le template 'chiffre_affaire/edit.html.twig' avec l'opération et le formulaire
    return $this->render('chiffre_affaire/edit.html.twig', [
        'operation' => $operation,
        'form' => $form->createView(),
    ]);
}

// Action pour supprimer une opération spécifique
#[Route('/{id}', name: 'app_chiffre_affaire_delete', methods: ['POST'])]
public function delete(Request $request, Operation $operation): Response
{
    // Vérifier la validité du jeton CSRF
    if ($this->isCsrfTokenValid('delete'.$operation->getId(), $request->request->get('_token'))) {
        // Supprimer l'opération de la base de données
        $this->entityManager->remove($operation);
        $this->entityManager->flush();
    }

    // Rediriger l'utilisateur vers la liste des opérations
    return $this->redirectToRoute('app_chiffre_affaire_index', [], Response::HTTP_SEE_OTHER);
}}





