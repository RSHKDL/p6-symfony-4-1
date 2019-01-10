<?php

namespace App\Controller\UsersController;

use App\Controller\UsersController\Interfaces\ForgotPasswordControllerInterface;
use App\Form\ForgotPasswordType;
use App\FormHandler\ForgotPasswordHandler;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

/**
 * Class ForgotPasswordController
 * @package App\Controller\UsersController
 */
final class ForgotPasswordController implements ForgotPasswordControllerInterface
{
    /**
     * @var ForgotPasswordHandler
     */
    private $handler;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var Environment
     */
    private $environment;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * ForgotPasswordController constructor.
     * @inheritdoc
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $environment,
        UrlGeneratorInterface $urlGenerator,
        ForgotPasswordHandler $handler
    ) {
        $this->handler = $handler;
        $this->formFactory = $formFactory;
        $this->environment = $environment;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @inheritdoc
     * @Route("/user/forgot-password", name="user_forgot_password", methods={"GET", "POST"})
     */
    public function forgotPassword(Request $request)
    {
        $form = $this->formFactory->create(ForgotPasswordType::class)->handleRequest($request);
        if ($this->handler->handle($form)) {
            return new RedirectResponse(
                $this->urlGenerator->generate('home')
            );
        }
        return new Response(
            $this->environment->render('user/reset.html.twig', [
                'form' => $form->createView()
            ])
        );
    }
}
