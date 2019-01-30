<?php

namespace App\UI\Helper\Interfaces;

interface ForgotPasswordMailInterface
{
    public function createMail(string $email, string $username, string $token);
}
