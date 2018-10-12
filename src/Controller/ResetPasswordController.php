<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\ForgotPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ResetPasswordController extends Controller
{

    /**
     * @param Request $request
     * @Route("/forgot-password", name="forgot_password")
     */
    public function requestPassword(Request $request, \Swift_Mailer $mailer)
    {
        // $tmpUser = new User();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            /** @var User $user */
            $user = $em->getRepository(User::class)->findOneBy([
                'email' => $data["email"]
            ]);

            if ($user) {

                if ($user->getConfirmationToken() == null) {
                    /** @var $tokenGenerator TokenGeneratorInterface */
                    $token = md5(uniqid($user->getUsername(), true));
                    $user->setConfirmationToken($token);
                    $user->setPasswordRequestedAt(new \DateTime());
                    $em->persist($user);
                    $em->flush();

                    $this->addFlash('info', 'You will receive an email with further instructions.');

                    // send mail logic with token
                    $message = (new \Swift_Message('Change password request'))
                        ->setFrom('sendl@mail.com')
                        ->setTo($user->getEmail())
                        ->setBody(
                            $this->renderView('emails/forgotten_password.html.twig', [
                                'user' => $user,
                                'token' => $token
                            ]), 'text/html'
                        );

                    $mailer->send($message);
                    return $this->redirectToRoute('home');
                }

            } else {
                $this->addFlash('danger', 'No match');
                return $this->redirectToRoute('forgot_password');
            }
        }

        return $this->render("security/request.html.twig", [
            "request_form" => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param $token
     * @Route("/reset-password/{token}", name="reset_password")
     */
    public function resetPassword(Request $request, $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var User $user */
        $user = $em->getRepository(User::class)->findOneBy([
           'confirmationToken' => $token
        ]);

        if ($user == null) {
            $this->addFlash('danger', 'Access denied');
            return $this->redirectToRoute('forgot_password');
        }

        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $plainPassword = $data['plainPassword'];
            $user->setPlainPassword($plainPassword);
            // Encode the password (could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setConfirmationToken(null);
            $user->setPasswordRequestedAt(null);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Your password has been reset, log in now');
            return $this->redirectToRoute('login');
        }

        return $this->render('security/reset.html.twig', [
            'reset_form' => $form->createView()
        ]);
    }
}
