<?php

namespace App\Controller;

use App\Entity\Operation;
use App\Form\OperationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Form\RapportType;

class OperationController extends AbstractController
{
    #[Route('/operation', name: 'app_operation')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $operations = $entityManager->getRepository(Operation::class)->findAll();

        return $this->render('operation/index.html.twig', [
            'controller_name' => 'OperationController',
            'operations' => $operations,
        ]);
    }

    #[Route('/operation/{id}/edit', name: 'app_operation_edit')]
    #[Security('is_granted("ROLE_EXPERT")')] //autorise uniquement l'expert
    public function edit(EntityManagerInterface $entityManager, Operation $operation, Request $request): Response
    {
       
        // Créez un formulaire pour la modification de l'employé (vous devez créer ce formulaire)
        $form = $this->createForm(OperationType::class, $operation);
        
        // Gérez la soumission du formulaire et mettez à jour l'employé
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Vous n'avez pas besoin de récupérer l'ID et le matricule ici, car $operation contient déjà ces informations
            // Par exemple, vous pouvez accéder à l'ID avec $operation->getId() et au matricule avec $operation->getEmploye()->getMatricule()

            // Enregistrez les modifications dans la base de données
            $entityManager->flush();

            // Redirigez l'utilisateur vers la page de tableau de bord ou une autre page appropriée
            return $this->redirectToRoute('app_operation', [], Response::HTTP_SEE_OTHER);
        }

        // Affichez le formulaire pour la modification de l'employé
        return $this->render('operation/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/operation/finish/{id}', name: 'app_operation_finish')]
    public function finishOperation(EntityManagerInterface $entityManager, Operation $operation): Response
    {
        // Appelez la méthode finish() pour marquer l'opération comme terminée
        $operation->finish();
        
        // Enregistrez les modifications dans la base de données
        $entityManager->flush();
        
        // Répondez avec une réponse JSON ou une réponse appropriée
        return $this->json(['success' => false]);
    }

    public function generatePdfAndSendEmail(Operation $operation, Request $request, MailerInterface $mailer): Response
    {   
        // Récupérez l'opération associée à la demande
        $demande = $operation->getDemande();

        // Récupérez le client associé à la demande
        $client = $demande->getClient();

        // Maintenant, vous pouvez accéder à l'adresse e-mail du client
        $clientEmail = $client->getEmail();
 
        // Générez le PDF ici en utilisant Dompdf
        // Utilisez les données de l'opération ou d'autres données pour générer le contenu du PDF
        $pdfContent = $this->renderView('pdf_generator/index.html.twig', [
            'operation' => $operation,
        ]);

        // Utilisez les options de Dompdf pour configurer Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($pdfContent);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Enregistrez le PDF sur le serveur ou dans un répertoire temporaire
        $pdfPath = $this->getParameter('kernel.project_dir') . '/public/pdfs/client.pdf';

        file_put_contents($pdfPath, $dompdf->output());

        // Envoyez le mail avec le PDF en pièce jointe en utilisant le composant Symfony Mailer
        $form = $this->createForm(RapportType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $adress =$data['email']; ;
            $content = $data['contenu'];

            $email = (new Email())
                ->from('propar@propar.com')
                ->to($adress)
                ->subject('Rapport')
                ->text($content)
                ->attachFromPath($pdfPath); // Attachez le PDF au courrier

            $mailer->send($email);

            // Supprimez le PDF temporaire si nécessaire
            unlink($pdfPath);

            // Vous pouvez renvoyer une réponse JSON pour indiquer le succès
            return new JsonResponse(['message' => 'PDF généré et email envoyé avec succès.']);
        }

        return $this->render('email/index.html.twig', [
            'controller_name' => 'EmailController',
            'formulaire' => $form,
        ]);
    }
}
