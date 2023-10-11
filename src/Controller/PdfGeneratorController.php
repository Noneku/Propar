<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Operation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfGeneratorController extends AbstractController
{

    #[Route('/pdf/generator/{id}/{id_operation}', name: 'app_pdf_generator')]
    public function generatePdf(Client $client, Operation $operation)
    {
        // Utilise les données du client pour générer le contenu du PDF
        $pdfContent = $this->renderView('pdf_generator/index.html.twig', [
            'client' => $client,
            'operation' => $operation,
        ]);

        // Utilisez les options de Dompdf pour configurer Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($pdfContent);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Définissez un chemin pour enregistrer le fichier PDF temporaire
        $pdfFileName = tempnam(sys_get_temp_dir(), 'invoice');
        file_put_contents($pdfFileName, $dompdf->output());

        // Retournez le chemin du fichier temporaire
        return $pdfFileName;
        // Génère la réponse PDF
        // $response = new Response($dompdf->output());
        // $response->headers->set('Content-Type', 'application/pdf');
        // $response->headers->set('Content-Disposition', 'inline; filename="client.pdf"');

        // return $response;
    }
}
