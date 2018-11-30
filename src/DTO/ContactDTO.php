<?php

namespace App\DTO;

use App\DTO\Interfaces\ContactDTOInterface;

final class ContactDTO implements ContactDTOInterface
{

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $subject;

    /**
     * @var string
     */
    public $message;

    /**
     * @inheritdoc
     */
    public function __construct(
        string $name,
        string $email,
        string $subject,
        string $message
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
    }
}
