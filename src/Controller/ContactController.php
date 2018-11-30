<?php

namespace App\Controller;

use App\Controller\Interfaces\ContactControllerInterface;
use App\Form\ContactType;
use App\FormHandler\Interfaces\ContactHandlerInterface;
use App\Responder\Interfaces\TwigRedirectResponderInterface;
use App\Responder\Interfaces\TwigResponderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact", name="contact" , methods={"GET", "POST"})
 *
 * Class ContactController
 * @package App\Controller
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
            return $redirectResponder('contact');
        }
        return $responder('contact/index.html.twig', [
            'contact_form' => $form->createView()
        ]);
    }
}
