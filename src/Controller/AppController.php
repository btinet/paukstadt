<?php

namespace App\Controller;

use Error;
use ErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_')]
class AppController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        if($request->isMethod('post')) {
            $company = $request->request->get('company');
            $firstname = $request->request->get('firstname');
            $lastname = $request->request->get('lastname');
            $email = $request->request->get('email');
            $phone = $request->request->get('phone');
            $message = utf8_encode($request->request->get('message'));
            $result = $request->request->get('result');
            if($result == (string)15) {
                $mailMessage = "Folgende Anfrage wurde gerade gemacht:\n\n";
                $mailMessage .= "Firma: $company\n";
                $mailMessage .= "Vorname: $firstname\n";
                $mailMessage .= "Nachname: $lastname\n";
                $mailMessage .= "E-Mail-Adresse: $email\n";
                $mailMessage .= "Telefon: $phone\n\n";
                $mailMessage .= "Nachricht:\n";
                $mailMessage .= "$message";
                mail('bwagner@vapita.de','Anfrage über Website',$mailMessage);
            }
        }


        return $this->render('app/index.html.twig', [
        ]);
    }

    #[Route('/datenschutz', name: 'privacy')]
    public function privacy(): Response
    {
        return $this->render('app/privacy.html.twig', [
        ]);
    }

    #[Route('/impressum', name: 'imprint')]
    public function imprint(): Response
    {
        return $this->render('app/imprint.html.twig', [
        ]);
    }
}
