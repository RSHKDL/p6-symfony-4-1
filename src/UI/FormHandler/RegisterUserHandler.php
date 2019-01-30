<?php

namespace App\UI\FormHandler;

use App\Domain\Entity\User;
use App\UI\FormHandler\Interfaces\RegisterUserHandlerInterface;
use App\UI\Helper\Interfaces\RegisterUserMailInterface;
use App\Domain\Repository\UserRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

final class RegisterUserHandler implements RegisterUserHandlerInterface
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

    /**
     * RegisterUserHandler constructor.
     * @inheritdoc
     */
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
     * @inheritdoc
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
