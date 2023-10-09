<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Repository\DemandeRepository;
use App\Repository\OperationRepository;
use App\Repository\PrestationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\DatesType;

class AffairesController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/affaires', name: 'app_affaires')]
    public function index(Request $request, OperationRepository $operationRepository, PrestationRepository $prestationRepository, DemandeRepository $demandeRepository): Response
    {
        $form = $this->createForm(DatesType::class);
        $form->handleRequest($request);

        $operations = [];
        $total1 = 0;
        $total2 = 0;
        $total3 = 0;
        $chiffreAffaire = 0;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $dateDebut = $data['dateEntree'];
            $dateFin = $data['dateSortie'];

            // Récupérer les opérations avec le statut "0" entre les dates choisies
            $operations = $operationRepository->findOperationsByDateRange($dateDebut, $dateFin);

            // Calculer le chiffre d'affaires total et les totaux par catégorie
            foreach ($operations as $operation) {
                $demande = $operation->getDemande();

                if ($demande) {
                    $prestationId = $demande->getPrestation()->getId();
                    $prix = $demande->getPrestation()->getPrix();

                    // Ajouter le prix de la prestation à la catégorie correspondante
                    if ($prestationId == $prestationId) {
                        $total1 += $prix;
                    } elseif ($prestationId == $prestationId) {
                        $total2 += $prix;
                    } elseif ($prestationId == $prestationId) {
                        $total3 += $prix;
                    }

                    // Ajouter le prix de la prestation au chiffre d'affaires total
                    $chiffreAffaire += $prix;
                }
            }
        }

        return $this->render('affaires/index.html.twig', [
            'controller_name' => 'AffairesController',
            'form' => $form->createView(),
            'operation' => $operations,
            'total1' => $total1,
            'total2' => $total2,
            'total3' => $total3,
            'chiffreAffaire' => $chiffreAffaire,
        ]);
    }
}