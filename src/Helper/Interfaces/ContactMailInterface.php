<?php

namespace App\Helper\Interfaces;

interface ContactMailInterface
{

    /**
     * @param string $subject
     * @param string $from
     * @param string $username
     * @param string $message
     * @return mixed
     */
    public function CreateMail(string $subject, string $from, string $username, string $message);
}
