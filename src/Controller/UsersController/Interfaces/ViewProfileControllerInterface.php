<?php

namespace App\Controller\UsersController\Interfaces;

use App\Repository\UserRepository;

interface ViewProfileControllerInterface
{
    /**
     * ViewProfileControllerInterface constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository);

    /**
     * @param int $id
     * @return mixed
     */
    public function view(int $id);
}
