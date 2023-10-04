<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileClientController extends AbstractController
{

    #[Route(path: '/profile', name: 'app_profile_show')]

    public function show(): Response
    {
        $client = $this->getUser();

        return $this->render('profile/show.html.twig', [
            'client' => $client,
        ]);
    }


    #[Route(path: '/profile/edit', name: 'app_profile_edit')]


    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {   
        $client = $this->getUser();

        $form = $this->createForm(ClientType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Met à jour les données du profil dans la base de données

            $entityManager->flush();

            // Redirige l'utilisateur vers la page de profil
            return $this->redirectToRoute('app_profile_show');
        }

        return $this->render('profile/edit.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }
}
