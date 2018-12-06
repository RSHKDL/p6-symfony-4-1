<?php

namespace App\Builder;

use App\DTO\UserDTO;
use App\DTO\Interfaces\UserDTOInterface;
use App\Entity\ContactMessage;

class UserBuilder
{

    public function create(UserDTO $contactDTO): ContactMessage
    {
        $contactMessage = new ContactMessage(
            $contactDTO->name,
            $contactDTO->email,
            $contactDTO->subject,
            $contactDTO->message
        );

        return $contactMessage;
    }
}
