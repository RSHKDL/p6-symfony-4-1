<?php

namespace App\UI\Controller\UsersController\Interfaces;

use App\UI\FormHandler\ResetPasswordHandler;
use App\Domain\Repository\UserRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

interface ResetPasswordControllerInterface
{

    /**
     * ResetPasswordControllerInterface constructor.
     * @param UserRepository $repository
     * @param FormFactoryInterface $formFactory
     * @param Environment $environment
     * @param UrlGeneratorInterface $urlGenerator
     * @param ResetPasswordHandler $handler
     */
    public function __construct(
        UserRepository $repository,
        FormFactoryInterface $formFactory,
        Environment $environment,
        UrlGeneratorInterface $urlGenerator,
        ResetPasswordHandler $handler
    );

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function resetPassword(Request $request);
}