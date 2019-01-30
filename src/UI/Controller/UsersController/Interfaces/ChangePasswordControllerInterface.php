<?php

namespace App\UI\Controller\UsersController\Interfaces;

use App\Domain\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Interface ChangePasswordControllerInterface
 * @package App\UI\Controller\UsersController\Interfaces
 */
interface ChangePasswordControllerInterface
{

    /**
     * ChangePasswordControllerInterface constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder);

    /**
     * @param Request $request
     * @param User $user
     * @return mixed
     */
    public function changePassword(Request $request, User $user);

    /**
     * @param User $user
     * @return Response
     */
    public function renderForm(User $user): Response;
}
