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
                $mail->CharSet = PHPMailer::CHARSET_UTF8;

                $mailMessage = $this->render('mail/mail.html.twig',[
                    'company' => $company,
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $email,
                    'phone' => $phone,
                    'message' => $message,
                ]);

                try {
                    $mail->setFrom('no-reply@bausanierung-paukstadt.de', 'Website-Formular');
                    $mail->addAddress('bausan.paukstadt@web.de', 'Bausanierung Paukstadt');     //Add a recipient
                    $mail->Subject = 'Anfrage vom Website-Formular';
                    $mail->isHTML(true);
                    $mail->Body    = $mailMessage;
                    $this->addFlash('success','E-Mail wurde erfolgreich versendet. Wir melden uns bald bei Ihnen.');
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
