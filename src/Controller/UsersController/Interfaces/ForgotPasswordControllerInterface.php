<?php

namespace App\Controller\UsersController\Interfaces;

use App\FormHandler\ForgotPasswordHandler;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

interface ForgotPasswordControllerInterface
{

    /**
     * ForgotPasswordControllerInterface constructor.
     * @param FormFactoryInterface $formFactory
     * @param Environment $environment
     * @param UrlGeneratorInterface $urlGenerator
     * @param ForgotPasswordHandler $handler
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $environment,
        UrlGeneratorInterface $urlGenerator,
        ForgotPasswordHandler $handler
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
    public function forgotPassword(Request $request);
}