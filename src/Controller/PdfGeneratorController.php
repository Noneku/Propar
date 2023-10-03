<?php
 
 namespace App\Controller;

 use App\Entity\Client;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\Routing\Annotation\Route;
 use Dompdf\Dompdf;
 use Dompdf\Options;
 
 class PdfGeneratorController extends AbstractController
 {
    #[Route('/pdf/generator/{id}', name: 'app_pdf_generator')]
   
     public function generatePdf(Client $client): Response
{
    // Utilisez les données du client pour générer le contenu du PDF
    $pdfContent = $this->renderView('pdf_generator/index.html.twig', [
        'client' => $client,
    ]);

    // Utilisez les options de Dompdf pour configurer Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);

    $dompdf = new Dompdf($options);

    $dompdf->loadHtml($pdfContent);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return new Response(
        $dompdf->stream('client.pdf', ['Attachment' => false]),
        Response::HTTP_OK,
        ['Content-Type' => 'application/pdf']
    );
}
 }
 