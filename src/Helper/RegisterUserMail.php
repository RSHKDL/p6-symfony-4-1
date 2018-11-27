<?php

namespace App\Helper;

use App\Service\Interfaces\MailerInterface;
use Twig\Environment;

class RegisterUserMail
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
     * Create and send a mail when a new User register, with a validation token.
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
            'Validate your Snowtricks Account',
            $this->adminMail,
            $email,
            $this->environment->render('emails/validate_registration.html.twig', [
                'username' => $username,
                'token' => $token
            ])
        );
    }
}
