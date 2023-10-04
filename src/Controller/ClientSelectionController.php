<?php

namespace App\Controller;


use App\Entity\Client;
use App\Entity\Demande;
use App\Entity\Operation;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ClientSelectionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientSelectionController extends AbstractController

{
    #[Route('/select_client', name: 'app_select_client')]
    public function selectClient(Request $request): Response
{
    $form = $this->createForm(ClientSelectionType::class);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $operation = $form->get('operation')->getData();
        $client = $operation->getDemande()->getClient();
        
        // accés aux propriétés du client (nom, prénom, etc.)
        $nom = $client->getNom();
        $prenom = $client->getPrenom();
        $adresse = $client->getAdresse();
        $tel = $client->getTel();
        $email = $client->getEmail();

        // Envoi de mail au client après

        // Redirigez vers l'action de génération de PDF en passant l'ID du client
        return $this->redirectToRoute('app_pdf_generator', ['id' => $client->getId()]);
    }

    return $this->render('client_selection/client_selection.html.twig', [
        'form' => $form->createView(),
    ]);
}

}


