<?php

namespace App\UI\Helper\Interfaces;

interface RegisterUserMailInterface
{
    public function createMail(string $email, string $username, string $token);
}
