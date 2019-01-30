<?php

namespace App\UI\FormHandler\Interfaces;

use Symfony\Component\Form\FormInterface;

interface ContactHandlerInterface
{

    /**
     * @param FormInterface $form
     * @return mixed
     */
    public function handle(FormInterface $form);
}
