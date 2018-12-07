<?php

namespace App\FormHandler;

use App\Entity\User;
use App\Helper\Interfaces\RegisterUserMailInterface;
use App\Helper\RegisterUserMail;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Twig\Environment;

final class RegisterUserHandler
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * @var TokenGeneratorInterface
     */
    private $tokenGenerator;
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;
    /**
     * @var RegisterUserMailInterface
     */
    private $registerUserMail;

    public function __construct(
        UserRepository $repository,
        UserPasswordEncoderInterface $passwordEncoder,
        TokenGeneratorInterface $tokenGenerator,
        FlashBagInterface $flashBag,
        RegisterUserMailInterface $registerUserMail

    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->tokenGenerator = $tokenGenerator;
        $this->repository = $repository;
        $this->flashBag = $flashBag;
        $this->registerUserMail = $registerUserMail;
    }

    /**
     * @param FormInterface $form
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(FormInterface $form): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $password = $this->passwordEncoder->encodePassword($user, $form->getData()->getPlainPassword());
            $token = md5(uniqid($form->getData()->getUsername(), true));

            $user->setUsername($form->getData()->getUsername());
            $user->setEmail($form->getData()->getEmail());
            $user->setPassword($password);
            $user->setConfirmationToken($token);
            $this->repository->save($user);

            $this->registerUserMail->createMail(
                $user->getEmail(),
                $user->getUsername(),
                $token
            );

            $this->flashBag->set(
                'info',
                'A mail has been sent at '.$form->getData()->getEmail().' with further instructions.'
            );
            return true;
        }
        return false;
    }
}