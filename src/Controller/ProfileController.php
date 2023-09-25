<?php

// src/Controller/ProfileController.php
use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
 
    #[Route(path: '/profile/{id}', name: 'profile_show')]
   
    public function show(Client $client): Response
    {
        return $this->render('profile/show.html.twig', [
            'client' => $client,
        ]);
    }

    
    #[Route(path: '/profile/edit/{id}', name: 'profile_edit')]
     

public function edit(Client $client, Request $request, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(ClientType::class, $client);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Mettez à jour les données du profil dans la base de données

        $entityManager->flush();

        // Redirigez l'utilisateur vers la page de profil
        return $this->redirectToRoute('profile_show', ['id' => $client->getId()]);
    }

    return $this->render('profile/edit.html.twig', [
        'client' => $client,
        'form' => $form->createView(),
    ]);
    }
}

