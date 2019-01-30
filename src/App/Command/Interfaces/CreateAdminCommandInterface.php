<?php

namespace App\App\Command\Interfaces;

use App\Domain\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Interface CreateAdminCommandInterface
 * @package App\App\Command\Interfaces
 */
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
