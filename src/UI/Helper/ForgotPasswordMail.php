<?php

namespace App\UI\Helper;

use App\UI\Helper\Interfaces\ForgotPasswordMailInterface;
use App\App\Service\Interfaces\MailerInterface;
use Twig\Environment;

final class ForgotPasswordMail implements ForgotPasswordMailInterface
{

    /**
     * @var MailerInterface
     */
    private $mailer;
    /**
     * @var string
     */
    private $adminMail;
    /**
     * @var Environment
     */
    private $environment;

    public function __construct(
        MailerInterface $mailer,
        Environment $environment,
        string $adminMail
    ) {
        $this->mailer = $mailer;
        $this->adminMail = $adminMail;
        $this->environment = $environment;
    }

    /**
     * Create and send a mail when a User has forgot his password,
     * with a validation token.
     *
     * @param string $email
     * @param string $username
     * @param string $token
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function createMail(string $email, string $username, string $token)
    {
        $this->mailer->sendMail(
            'You forgot your Snowtricks password!',
            $this->adminMail,
            $email,
            $this->environment->render('emails/forgotten_password.html.twig', [
                'username' => $username,
                'token' => $token
            ])
        );
    }
}
