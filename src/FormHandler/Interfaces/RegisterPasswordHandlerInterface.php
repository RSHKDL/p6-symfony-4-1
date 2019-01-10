<?php

namespace App\FormHandler\Interfaces;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

interface RegisterPasswordHandlerInterface
{

    /**
     * RegisterPasswordHandlerInterface constructor.
     * @param UserRepository $repository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param FlashBagInterface $flashBag
     */
    public function __construct(
        UserRepository $repository,
        UserPasswordEncoderInterface $passwordEncoder,
        FlashBagInterface $flashBag
    );

    /**
     * @param FormInterface $form
     * @param User $user
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(FormInterface $form, User $user): bool;
}
