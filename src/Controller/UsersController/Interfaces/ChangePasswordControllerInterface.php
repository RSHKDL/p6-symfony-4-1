<?php

namespace App\Controller\UsersController\Interfaces;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
