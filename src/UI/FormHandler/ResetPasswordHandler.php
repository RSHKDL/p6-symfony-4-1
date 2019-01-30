<?php

namespace App\UI\FormHandler;

use App\Domain\Entity\User;
use App\UI\FormHandler\Interfaces\RegisterPasswordHandlerInterface;
use App\Domain\Repository\UserRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class ResetPasswordHandler implements RegisterPasswordHandlerInterface
{
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * ResetPasswordHandler constructor.
     * @inheritdoc
     */
    public function __construct(
        UserRepository $repository,
        UserPasswordEncoderInterface $passwordEncoder,
        FlashBagInterface $flashBag
    ) {
        $this->repository = $repository;
        $this->passwordEncoder = $passwordEncoder;
        $this->flashBag = $flashBag;
    }

    /**
     * @inheritdoc
     */
    public function handle(FormInterface $form, User $user): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $plainPassword = $data['plainPassword'];
            $password = $this->passwordEncoder->encodePassword($user, $plainPassword);
            $user->setPassword($password);
            $user->setConfirmationToken(null);
            $user->setPasswordRequestedAt(null);
            $this->repository->save($user);

            $this->flashBag->set('success', 'Your password has been reset, log in now!');
            return true;
        }
        return false;
    }
}
