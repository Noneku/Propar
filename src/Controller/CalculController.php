<?php

namespace App\Controller;

use App\Entity\Operation;
use App\Form\Operation1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function calculateChiffreDaffairesByYear(\DateTime $startDate, \DateTime $endDate): array
    {
        $chiffreAffaires = [];
    
        // Récupérer les opérations terminées entre les dates spécifiées
        $operations = $this->entityManager
            ->createQueryBuilder()
            ->select('o, d, p')
            ->from(Operation::class, 'o')
            ->leftJoin('o.demande', 'd')
            ->leftJoin('d.prestation', 'p')
            ->where('o.status = :status')
            ->andWhere('o.dateOperation BETWEEN :startDate AND :endDate')
            ->setParameter('status', true)
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getResult();
    
        // Calculer le chiffre d'affaires pour chaque année
        foreach ($operations as $operation) {
            $annee = $operation->getDateOperation()->format('Y');
            $chiffreAffaire = $operation->getDemande()->getPrestation()->getPrix();
    
            // Ajouter le chiffre d'affaires à l'année correspondante
            $chiffreAffaires[$annee] = ($chiffreAffaires[$annee] ?? 0) + $chiffreAffaire;
        }
    
        return $chiffreAffaires;
    }
}
