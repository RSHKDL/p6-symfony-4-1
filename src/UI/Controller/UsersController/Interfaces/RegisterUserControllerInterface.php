<?php

namespace App\UI\Controller\UsersController\Interfaces;

use App\UI\FormHandler\RegisterUserHandler;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

interface RegisterUserControllerInterface
{

    /**
     * RegisterUserControllerInterface constructor.
     * @param FormFactoryInterface $formFactory
     * @param RegisterUserHandler $handler
     * @param Environment $environment
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        RegisterUserHandler $handler,
        Environment $environment,
        UrlGeneratorInterface $urlGenerator
    );

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function registerUser(Request $request);
}
