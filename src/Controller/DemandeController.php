<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\DemandeType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemandeController extends AbstractController
{
    #[Route('/demande', name: 'app_demande')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {   
       // Obtenez toutes les prestations
    //    $prestations = $entityManager->getRepository(Prestation::class)->findAll();


       // Vérifiez si l'utilisateur est connecté
       $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

       // Obtenez l'utilisateur connecté
       $user = $this->getUser();

       // Créez une nouvelle instance de l'entité Demande
       $demande = new Demande();

       // Créez le formulaire en utilisant le formulaire DemandeType
       $form = $this->createForm(DemandeType::class, $demande);
        
       // Gérez la soumission du formulaire
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {

        $entityPrestation = $form->get('prestation')->getData();
        $dateDemande  = new DateTime();

           $demande->setClient($user);
           $demande->setPrestation($entityPrestation);
           $demande->setDateDemande($dateDemande);
           $entityManager->persist($demande);
           $entityManager->flush();

           // Envoie un e-mail pour notifier la soumission de la demande
           $this->sendNotificationEmail($user, $demande, $mailer);

           // Redirigez vers une autre page ou effectuez une autre action
           return $this->redirectToRoute('app_home');
       }
          
       return $this->render('demande/index.html.twig', [
           'controller_name' => 'DemandeController',
           'user' => $user,
           'form' => $form
       ]);
   }

   private function sendNotificationEmail($user, $demande, $mailer)
   {
       $email = (new Email())
           ->from('votre_email@example.com') // Remplacez par votre adresse e-mail
           ->to($user->getEmail()) // Utilisez l'e-mail de l'utilisateur
           ->subject('Nouvelle demande soumise')
           ->html('<p>Votre demande a été soumise avec succès.</p>'); // Personnalisez le contenu de l'e-mail selon vos besoins

       $mailer->send($email);
   }
}
