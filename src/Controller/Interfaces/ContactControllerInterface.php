<?php

namespace App\Controller\Interfaces;

use App\FormHandler\Interfaces\ContactHandlerInterface;
use App\Responder\Interfaces\TwigRedirectResponderInterface;
use App\Responder\Interfaces\TwigResponderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

interface ContactControllerInterface
{
    /**
     * ContactControllerInterface constructor.
     * @param ContactHandlerInterface $handler
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        ContactHandlerInterface $handler,
        FormFactoryInterface $formFactory
    );

    /**
     * @param Request $request
     * @param TwigResponderInterface $responder
     * @param TwigRedirectResponderInterface $redirectResponder
     * @return mixed
     */
    public function __invoke(
        Request $request,
        TwigResponderInterface $responder,
        TwigRedirectResponderInterface $redirectResponder
    );
}
