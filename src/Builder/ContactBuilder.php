<?php

namespace App\Builder;

use App\DTO\ContactDTO;
use App\DTO\Interfaces\ContactDTOInterface;
use App\Entity\ContactMessage;

class ContactBuilder
{

    public function create(ContactDTO $contactDTO): ContactMessage
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
