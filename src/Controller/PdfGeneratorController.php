<?php
 
 namespace App\Controller;

 use App\Entity\Client;
 use Doctrine\ORM\EntityManagerInterface;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\Routing\Annotation\Route;
 use Dompdf\Dompdf;
 use Dompdf\Options;
 
 class PdfGeneratorController extends AbstractController
 {
     private $entityManager;
 
     public function __construct(EntityManagerInterface $entityManager)
     {
         $this->entityManager = $entityManager;
     }
 
     #[Route('/pdf/generator/{clientNom}', name: 'app_pdf_generator')]
     public function index($clientNom): Response
     {
        // Débogage
        // dump($clientNom);
         // Utilisez $clientNom pour récupérer le client correspondant depuis la base de données
         $client = $this->entityManager->getRepository(Client::class)->findOneBy(['nom' => $clientNom]);
        // Débogage
        // dump($client);
         if (!$client) {
             throw $this->createNotFoundException('Client_non_trouve');
         }
 
         $data = [
             'nom'     => $client->getNom(),
             'prenom'  => $client->getPrenom(),
             'address' => $client->getAdresse(),
             'tel'     => $client->getTel(),
             'email'   => $client->getEmail(),
         ];
 
         // Utilisez les options de Dompdf pour configurer Dompdf
         $options = new Options();
         $options->set('isHtml5ParserEnabled', true);
 
         $dompdf = new Dompdf($options);
 
         $html = $this->renderView('pdf_generator/index.html.twig', $data);
         $dompdf->loadHtml($html);
         $dompdf->setPaper('A4', 'portrait');
         $dompdf->render();
 
         return new Response(
             $dompdf->stream('resume.pdf', ['Attachment' => false]),
             Response::HTTP_OK,
             ['Content-Type' => 'application/pdf']
         );
     }
 }
 