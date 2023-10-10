<?php

namespace App\Controller;

use DateTime;
use App\Entity\Client;
use App\Entity\Demande;
use App\Entity\Operation;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\PdfGeneratorController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Part\FilePart;


class TraitementDemandeOperationController extends AbstractController
{
    private PdfGeneratorController $pdf;

    public function __construct(PdfGeneratorController $pdf)
    {
        $this->pdf = $pdf;
    }

    #[Route('/traitement/demande/operation/{id}', name: 'app_open_operation')]
    public function openOperation(EntityManagerInterface $entitymanager, $id)
    {
        //Catch ID of Demande by URL ID parameter
        $demande = $entitymanager->getRepository(Demande::class)->find($id);

        $operation = new Operation;

        $operation->setDemande($demande);
        //Replace User by entity type employee
        $operation->setEmploye($this->getUser());
        $operation->setStatus(false); //met le status '0' qui signifie opération en cours
        $dateOperation  = new DateTime();
        $operation->setDateOperation($dateOperation);

        $entitymanager->persist($operation);
        $entitymanager->flush();

        return $this->redirectToRoute('app_operation');
    }

    #[Route('/close/{id}', name: 'app_close_operation')]
    public function sendEmail(MailerInterface $mailer, int $id, EntityManagerInterface $entitymanager): Response
    {
        $client = $entitymanager->getRepository(Client::class)->find($id);
        $emailClient = $client->getEmail();

        // Générez le PDF en utilisant la méthode generatePdf
        $pdfFilePath = $this->pdf->generatePdf($client);

        // Vérifiez si le chemin du fichier PDF existe
        // if (file_exists($pdfFilePath)) {
            // Créez l'e-mail
            $email = (new Email())
                ->from('mailtrap@example.com')
                ->to($emailClient)
                ->subject('Time for Symfony Mailer!')
                ->text('plaplapalaplap')
                ->html('<p>See Twig integration for better HTML integration!</p>');

            // Joignez le fichier PDF au courriel
            $email->attachFromPath($pdfFilePath, 'client.pdf', 'application/pdf');

            // Envoyez l'e-mail en utilisant le contenu du fichier PDF
            $mailer->send($email);

            // Supprimez le fichier PDF temporaire après l'envoi
            unlink($pdfFilePath);
        // }

        // Retournez une réponse HTTP appropriée
        return new Response('Email Envoyé');
    }
}
