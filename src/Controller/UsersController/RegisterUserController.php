<?php

namespace App\Controller\UsersController;

use App\Form\UserRegisterType;
use App\FormHandler\RegisterUserHandler;
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
final class RegisterUserController
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

    public function __construct(
        FormFactoryInterface $formFactory,
        RegisterUserHandler $handler,
        Environment $environment,
        UrlGeneratorInterface $urlGenerator
    ){
        $this->formFactory = $formFactory;
        $this->handler = $handler;
        $this->environment = $environment;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/user/register", name="user_register", methods={"GET", "POST"})
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function registerUser(Request $request)
    {
        $form = $this->formFactory->create(UserRegisterType::class)->handleRequest($request);
        if ($this->handler->handle($form)) {
            return new RedirectResponse(
                $this->urlGenerator->generate('user_register')
            );
        }
        return new Response(
            $this->environment->render('security/register.html.twig', [
                'form' => $form->createView()
            ])
        );
    }
}
