<?php

namespace App\FormHandler;

use App\Builder\UserBuilder;
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

    public function __construct(

        ContactMailInterface $contactMail,
        FlashBagInterface $flashBag,
        UserBuilder $contactBuilder
    ) {
        $this->contactMail = $contactMail;
        $this->flashBag = $flashBag;
    }

    public function handle(FormInterface $form)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactMail->CreateMail(
                $form->get('subject')->getData(),
                $form->get('email')->getData(),
                $form->get('name')->getData(),
                $form->get('message')->getData()
            );

            $this->flashBag->set('success', 'Message successfully sent. Thank you !');
            return true;
        }
        return false;
    }
}
