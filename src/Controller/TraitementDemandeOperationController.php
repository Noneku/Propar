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

    #[Route('/close/{id}/{id_operation}', name: 'app_close_operation')]
    public function sendEmail(MailerInterface $mailer, int $id,int $id_operation, EntityManagerInterface $entitymanager): Response
    {
        $client = $entitymanager->getRepository(Client::class)->find($id);
        $operation = $entitymanager->getRepository(Operation::class)->find($id_operation);
        $emailClient = $client->getEmail();

        // Générez le PDF en utilisant la méthode generatePdf
        $pdfFilePath = $this->pdf->generatePdf($client, $operation);

        // Vérifiez si le chemin du fichier PDF existe
        if (file_exists($pdfFilePath)) {
            // Créez l'e-mail
            $email = (new Email())
                ->from('ProparEntreprise@gmail.com')
                ->to($emailClient)
                ->subject('Votre Facture Propar')
                ->text('plaplapalaplap')
                ->html("<p>Cher client,</p>
                <p>Merci d'avoir choisi Propar pour vos besoins en services. Nous sommes ravis de vous avoir comme client et nous vous remercions pour votre confiance.</p>
                <p>À Propar, notre engagement est de fournir des services de qualité exceptionnelle qui répondent à vos besoins et dépassent vos attentes. Nous travaillons continuellement pour vous offrir la meilleure expérience possible.</p>
                <p>Nous sommes à votre disposition pour toute question ou assistance supplémentaire. N'hésitez pas à nous contacter à tout moment.</p>
                <p>Encore une fois, merci d'avoir choisi Propar. Nous sommes impatients de vous servir et de vous accompagner dans votre parcours.</p>
                <p>Bien cordialement,</p>
                <p>L'équipe Propar</p>");

            // Joignez le fichier PDF au courriel
            $email->attachFromPath($pdfFilePath, 'client.pdf', 'application/pdf');

            // Envoyez l'e-mail en utilisant le contenu du fichier PDF
            $mailer->send($email);

            // Supprimez le fichier PDF temporaire après l'envoi
            unlink($pdfFilePath);
        }

        // Retournez une réponse HTTP appropriée
        return $this->redirectToRoute('app_operation', [], Response::HTTP_SEE_OTHER);
    }
}
