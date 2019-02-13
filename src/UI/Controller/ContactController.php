<?php

namespace App\UI\Controller;

use App\UI\Controller\Interfaces\ContactControllerInterface;
use App\UI\Form\ContactType;
use App\UI\FormHandler\Interfaces\ContactHandlerInterface;
use App\UI\Responder\Interfaces\TwigRedirectResponderInterface;
use App\UI\Responder\Interfaces\TwigResponderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact", name="contact" , methods={"GET", "POST"})
 *
 * Class ContactController
 * @package App\UI\Controller
 */
final class ContactController implements ContactControllerInterface
{

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var ContactHandlerInterface
     */
    private $handler;

    /**
     * @inheritdoc
     */
    public function __construct(
        ContactHandlerInterface $handler,
        FormFactoryInterface $formFactory
    ) {
        $this->handler = $handler;
        $this->formFactory = $formFactory;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(
        Request $request,
        TwigResponderInterface $responder,
        TwigRedirectResponderInterface $redirectResponder
    ) {
        $form = $this->formFactory->create(ContactType::class)->handleRequest($request);

        if ($this->handler->handle($form)) {
            return $redirectResponder('home');
        }
        return $responder('contact/index.html.twig', [
            'contact_form' => $form->createView()
        ]);
    }
}
