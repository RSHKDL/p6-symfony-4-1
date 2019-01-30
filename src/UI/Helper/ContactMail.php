<?php

namespace App\UI\Helper;

use App\UI\Helper\Interfaces\ContactMailInterface;
use App\App\Service\Interfaces\MailerInterface;
use Twig\Environment;

final class ContactMail implements ContactMailInterface
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

    /**
     * ContactMail constructor.
     * @param MailerInterface $mailer
     * @param Environment $environment
     * @param string $adminMail
     */
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
     * Create and send a contact mail
     *
     * @param string $subject
     * @param string $from
     * @param string $username
     * @param string $message
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function CreateMail(
        string $subject,
        string $from,
        string $username,
        string $message
    ) {
        $this->mailer->sendMail(
            'SnowTricks: '.$subject,
            [$from],
            $this->adminMail,
            $this->environment->render('emails/_email_contact.html.twig', [
                'message' => $message,
                'username' => $username
            ])
        );
    }
}
