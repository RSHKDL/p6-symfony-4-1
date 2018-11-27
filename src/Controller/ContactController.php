<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     *
     * To send mail, replace "setYourEmailHere" by your email address.
     * To use Gmail, read : https://symfony.com/doc/current/email.html#using-gmail-to-send-emails
     * You'll need to update the .env file.
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm('App\Form\ContactType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $message = (new \Swift_Message('Mail from Snowtricks'))
                ->setFrom($data['email'], $data['name'])
                ->setTo('rshkdl86@gmail.com')
                ->setSubject($data['subject'])
                ->setBody($data['message'], 'text/plain');

            $mailer->send($message);

            $this->addFlash('success', 'Message successfully sent. Thank you !');
            return $this->redirectToRoute('contact');
        }
        return $this->render('contact/index.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }
}
