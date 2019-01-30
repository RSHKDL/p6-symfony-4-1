<?php

namespace App\App\Service\Interfaces;

/**
 * Interface MailerInterface
 * @package App\App\Service\Interfaces
 */
interface MailerInterface
{

    /**
     * @param string $subject
     * @param string|array $from
     * @param string $to
     * @param string $body
     * @return mixed
     */
    public function sendMail($subject, $from = [], $to, $body);
}
