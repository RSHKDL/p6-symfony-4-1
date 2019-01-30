<?php

namespace App\UI\Controller\UsersController;

use App\UI\Controller\UsersController\Interfaces\RegisterUserControllerInterface;
use App\UI\Form\UserRegisterType;
use App\UI\FormHandler\RegisterUserHandler;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

/**
 * Class RegisterUserController
 * @package App\Controller\UserController
 */
final class RegisterUserController implements RegisterUserControllerInterface
{

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var RegisterUserHandler
     */
    private $handler;
    /**
     * @var Environment
     */
    private $environment;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * RegisterUserController constructor.
     * @inheritdoc
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        RegisterUserHandler $handler,
        Environment $environment,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->formFactory = $formFactory;
        $this->handler = $handler;
        $this->environment = $environment;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @inheritdoc
     * @Route("/user/register", 
     *     name="user_register", 
     *     methods={"GET", "POST"}
     * )
     */
    public function registerUser(Request $request)
    {
        $form = $this->formFactory->create(UserRegisterType::class)->handleRequest($request);
        if ($this->handler->handle($form)) {
            return new RedirectResponse(
                $this->urlGenerator->generate('home')
            );
        }
        return new Response(
            $this->environment->render('user/register.html.twig', [
                'form' => $form->createView()
            ])
        );
    }
}
