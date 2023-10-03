<?php

namespace App\Controller;

use DateTime;
use App\Entity\Demande;
use App\Entity\Employe;
use App\Entity\Operation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TraitementDemandeOperationController extends AbstractController
{
    #[Route('/traitement/demande/operation/{id}', name: 'app_open_operation')]
    public function openOperation(EntityManagerInterface $entitymanager,$id)
    {
        //Catch ID of Demande by URL ID parameter
        $demande = $entitymanager->getRepository(Demande::class)->find($id);

        $operation = new Operation;

        $operation->setDemande($demande);
        //Replace User by entity type employee
        $operation->setEmploye($this->getUser());
        $operation->setStatus(true);
        $dateOperation  = new DateTime();
        $operation->setDateOperation($dateOperation);

        $entitymanager->persist($operation);
        $entitymanager->flush();

        return $this->redirectToRoute('app_operation');
    }
    
}