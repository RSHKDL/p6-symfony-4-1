<?php

namespace App\UI\Controller\UsersController;

use App\UI\Controller\UsersController\Interfaces\ValidateUserControllerInterface;
use App\Domain\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

final class ValidateUserController implements ValidateUserControllerInterface
{

    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var Environment
     */
    private $environment;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * ValidateUserController constructor.
     * @inheritdoc
     */
    public function __construct(
        UserRepository $repository,
        Environment $environment,
        FlashBagInterface $flashBag,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->repository = $repository;
        $this->environment = $environment;
        $this->flashBag = $flashBag;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @inheritdoc
     * @Route("/user/validation/{token}", name="user_validate", methods={"GET"})
     */
    public function validateUser(Request $request)
    {
        $user = $this->repository->checkRegistrationToken($request->attributes->get('token'));
        if ($user) {
            $user->setIsActive(true);
            $user->setConfirmationToken(null);
            $this->repository->save($user);
            $this->flashBag->set('success', 'Your account was successfully validated, log in now');

            return new RedirectResponse(
                $this->urlGenerator->generate('user_login')
            );
        }
        return new Response(
            $this->environment->render('user/register_validation_error.html.twig')
        );
    }
}
