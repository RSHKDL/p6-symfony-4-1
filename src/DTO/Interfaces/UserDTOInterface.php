<?php

namespace App\DTO\Interfaces;

interface UserDTOInterface
{

    /**
     * ContactDTOInterface constructor.
     * @param string $name
     * @param string $email
     * @param string $subject
     * @param string $message
     */
    public function __construct(
        string $name,
        string $email,
        string $subject,
        string $message
    );
}
