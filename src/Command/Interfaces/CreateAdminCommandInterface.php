<?php

namespace App\Command\Interfaces;

use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

interface CreateAdminCommandInterface
{

    /**
     * CreateAdminCommandInterface constructor.
     * @param EncoderFactoryInterface $encoderFactory
     * @param UserRepository $repository
     * @param bool $username
     * @param bool $password
     * @param bool $email
     */
    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        UserRepository $repository,
        $username = true,
        $password = true,
        $email = true
    );
}
