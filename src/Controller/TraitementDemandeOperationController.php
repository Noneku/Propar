<?php

namespace App\Controller;

use App\Entity\Demande;
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

        $demande = $entitymanager->getRepository(Demande::class)->find($id);

        $operation = new Operation;

        $operation->setDemande($demande);
        //Replace User by entity type employee
        $operation->setEmploye($this->getUser());
        $operation->setStatus(true);

        $entitymanager->persist($operation);
        $entitymanager->flush();

        $this->redirectToRoute('app_operation');
    }
    
}
