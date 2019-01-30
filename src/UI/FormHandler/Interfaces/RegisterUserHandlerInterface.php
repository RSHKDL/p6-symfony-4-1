<?php

namespace App\UI\FormHandler\Interfaces;

use App\UI\Helper\Interfaces\RegisterUserMailInterface;
use App\Domain\Repository\UserRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

interface RegisterUserHandlerInterface
{

    /**
     * RegisterUserHandlerInterface constructor.
     * @param UserRepository $repository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param TokenGeneratorInterface $tokenGenerator
     * @param FlashBagInterface $flashBag
     * @param RegisterUserMailInterface $registerUserMail
     */
    public function __construct(
        UserRepository $repository,
        UserPasswordEncoderInterface $passwordEncoder,
        TokenGeneratorInterface $tokenGenerator,
        FlashBagInterface $flashBag,
        RegisterUserMailInterface $registerUserMail
    );

    /**
     * @param FormInterface $form
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(FormInterface $form): bool;
}
