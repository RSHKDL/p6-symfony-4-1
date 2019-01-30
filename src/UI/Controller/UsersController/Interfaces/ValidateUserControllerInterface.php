<?php

namespace App\UI\Controller\UsersController\Interfaces;

use App\Domain\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

interface ValidateUserControllerInterface
{

    /**
     * ValidateUserControllerInterface constructor.
     * @param UserRepository $repository
     * @param Environment $environment
     * @param FlashBagInterface $flashBag
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        UserRepository $repository,
        Environment $environment,
        FlashBagInterface $flashBag,
        UrlGeneratorInterface $urlGenerator
    );

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function validateUser(Request $request);
}
