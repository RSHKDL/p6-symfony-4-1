<?php

namespace App\Controller\UsersController\Interfaces;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface ChangeAvatarControllerInterface
{
    /**
     * @param Request $request
     * @param User $user
     * @return mixed
     */
    public function changeAvatar(Request $request, User $user);

    /**
     * @param User $user
     * @return Response
     */
    public function renderForm(User $user): Response;
}
