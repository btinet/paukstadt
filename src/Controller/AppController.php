<?php

namespace App\Controller;

use Error;
use ErrorException;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
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
            $message = $request->request->get('message');
            $result = $request->request->get('result');
            if($result == 15) {

                $mail = new PHPMailer(true);
                $mail->Encoding = PHPMailer::ENCODING_BASE64;

                $mailMessage = "Folgende Anfrage wurde gerade gemacht:\n\n";
                $mailMessage .= "Firma: $company\n";
                $mailMessage .= "Vorname: $firstname\n";
                $mailMessage .= "Nachname: $lastname\n";
                $mailMessage .= "E-Mail-Adresse: $email\n";
                $mailMessage .= "Telefon: $phone\n\n";
                $mailMessage .= "Nachricht:\n";
                $mailMessage .= "$message";

                try {
                    $mail->setFrom('no-reply@bausanierung-paukstadt.de', 'Website-Formular');
                    $mail->addAddress('kv@treptow-kolleg.de', 'Bausanierung Paukstadt');     //Add a recipient
                    $mail->Subject = 'Anfrage über Website';
                    $mail->Body    = $mailMessage;
                    $mail->send();
                } catch (Exception $e) {
                    die($mail->ErrorInfo);
                }
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
