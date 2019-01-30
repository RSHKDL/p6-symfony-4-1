<?php

namespace App\UI\FormHandler\Interfaces;

use App\UI\Helper\Interfaces\ForgotPasswordMailInterface;
use App\Domain\Repository\UserRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

interface ForgotPasswordHandlerInterface
{

    /**
     * ForgotPasswordHandlerInterface constructor.
     * @param UserRepository $repository
     * @param TokenGeneratorInterface $tokenGenerator
     * @param FlashBagInterface $flashBag
     * @param ForgotPasswordMailInterface $forgotPasswordMail
     */
    public function __construct(
        UserRepository $repository,
        TokenGeneratorInterface $tokenGenerator,
        FlashBagInterface $flashBag,
        ForgotPasswordMailInterface $forgotPasswordMail
    );

    /**
     * @param FormInterface $form
     * @return bool
     */
    public function handle(FormInterface $form): bool;
}
