<?php

namespace App\FormHandler;

use App\DTO\ContactDTO;
use App\Entity\ContactMessage;
use App\Entity\User;
use App\FormHandler\Interfaces\ContactHandlerInterface;
use App\Helper\Interfaces\ContactMailInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

final class ContactHandler implements ContactHandlerInterface
{
    /**
     * @var ContactMailInterface
     */
    private $contactMail;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;
    /**
     * @var ContactDTO
     */
    private $contactDTO;

    public function __construct(

        ContactMailInterface $contactMail,
        FlashBagInterface $flashBag,
        ContactDTO $contactDTO
    ) {
        $this->contactMail = $contactMail;
        $this->flashBag = $flashBag;
        $this->contactDTO = $contactDTO;
    }

    public function handle(FormInterface $form)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactMail->CreateMail(
                $this->contactDTO->subject,
                $this->contactDTO->email,
                $this->contactDTO->name,
                $this->contactDTO->message
            );

            $this->flashBag->set('success', 'Message successfully sent. Thank you !');
            return true;
        }
        return false;
    }
}
