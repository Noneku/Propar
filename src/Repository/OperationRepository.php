<?php

namespace App\Repository;

use App\Entity\Operation;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Operation>
 *
 * @method Operation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Operation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Operation[]    findAll()
 * @method Operation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operation::class);
    }

    /**
    * @return Operation[] Returns an array of Operation objects
    */
    private $entityManager;

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
    
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Operation
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
