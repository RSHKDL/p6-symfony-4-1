<?php

namespace App\Domain\DTO;

use App\Domain\DTO\Interfaces\UserDTOInterface;

final class UserDTO implements UserDTOInterface
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
