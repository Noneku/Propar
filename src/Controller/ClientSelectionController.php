<?php

namespace App\Controller;


use App\Entity\Client;
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
            $data = $form->getData();
            $clientNom = $data['client'];
            
            // Redirigez vers l'action de génération de PDF en passant l'ID du client
            return $this->redirectToRoute('app_pdf_generator', ['clientNom' => $clientNom]);
        }

        return $this->render('client_selection/client_selection.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

