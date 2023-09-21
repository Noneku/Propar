<?php

namespace App\Controller;

use App\Entity\Prestation;
use App\Entity\Demande;
use App\Form\DemandeType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemandeController extends AbstractController
{
    #[Route('/demande', name: 'app_demande')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {   
       // Obtenez toutes les prestations
       $prestations = $entityManager->getRepository(Prestation::class)->findAll();


       // Vérifiez si l'utilisateur est connecté
       $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

       // Obtenez l'utilisateur connecté
       $user = $this->getUser();

       // Créez une nouvelle instance de l'entité Demande
    //    $demande = new Demande();

    //    // Créez le formulaire en utilisant le formulaire DemandeType
    //    $form = $this->createForm(DemandeType::class, $demande, [
    //        'prestations' => $prestations, // Passez les prestations au formulaire
    //    ]);

    //    // Gérez la soumission du formulaire
    //    $form->handleRequest($request);
    //    if ($form->isSubmitted() && $form->isValid()) {
    //        // Traitez les données du formulaire ici, par exemple, enregistrez-les en base de données
    //     //    $entityManager->persist($demande);
    //     //    $entityManager->flush();

    //        // Redirigez vers une autre page ou effectuez une autre action
    //        return $this->redirectToRoute('votre_autre_route');
    //    }
          
       return $this->render('demande/index.html.twig', [
           'controller_name' => 'DemandeController',
           'user' => $user,
        //    'form' => $form->createView(), // Créez la vue du formulaire
       ]);
   }
}
