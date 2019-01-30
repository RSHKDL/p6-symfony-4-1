<?php

namespace App\UI\Controller\Interfaces;

use App\UI\FormHandler\Interfaces\ContactHandlerInterface;
use App\UI\Responder\Interfaces\TwigRedirectResponderInterface;
use App\UI\Responder\Interfaces\TwigResponderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface ContactControllerInterface
 * @package App\UI\Controller\Interfaces
 */
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
