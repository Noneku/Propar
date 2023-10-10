<?php

namespace App\Controller;

use App\Form\RapportType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class EmailController extends AbstractController
{
    #[Route('/email', name: 'app_email')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(RapportType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()) {
            
           $data= $form->getData();
        //    dd($data); 
   
            $adress=$data['email'];
            $content=$data['contenu'];
           
            $email = (new Email())
                ->from('propar@propar.com')
                ->to($adress)
                ->subject('Rapport')
                ->text($content);

                $mailer->send($email);

        }

        return $this->render('email/index.html.twig', [
            'controller_name' => 'EmailController',
            'formulaire'=>$form
        ]);
    }
}
