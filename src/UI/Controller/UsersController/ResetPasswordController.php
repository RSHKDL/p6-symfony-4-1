<?php

namespace App\UI\Controller\UsersController;

use App\UI\Controller\UsersController\Interfaces\ResetPasswordControllerInterface;
use App\UI\Form\ChangePasswordType;
use App\UI\FormHandler\ResetPasswordHandler;
use App\Domain\Repository\UserRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

/**
 * Class ResetPasswordController
 * @package App\Controller\UsersController
 */
final class ResetPasswordController implements ResetPasswordControllerInterface
{

    /**
     * @var UserRepository
     */
    private $repository;
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
     * @var ResetPasswordHandler
     */
    private $handler;

    /**
     * ResetPasswordController constructor.
     * @inheritdoc
     */
    public function __construct(
        UserRepository $repository,
        FormFactoryInterface $formFactory,
        Environment $environment,
        UrlGeneratorInterface $urlGenerator,
        ResetPasswordHandler $handler
    ) {
        $this->repository = $repository;
        $this->formFactory = $formFactory;
        $this->environment = $environment;
        $this->urlGenerator = $urlGenerator;
        $this->handler = $handler;
    }

    /**
     * @inheritdoc
     * @Route("/user/reset-password/{token}",
     *     name="user_reset_password",
     *     methods={"GET", "POST"}
     * )
     */
    public function resetPassword(Request $request)
    {
        $user = $this->repository->findOneBy([
           'confirmationToken' => $request->attributes->get('token')
        ]);

        if ($user) {
            $form = $this->formFactory->create(ChangePasswordType::class)->handleRequest($request);
            if ($this->handler->handle($form, $user)) {
                return new RedirectResponse(
                    $this->urlGenerator->generate('user_login')
                );
            }
            return new Response(
                $this->environment->render('user/reset.html.twig', [
                    'form' => $form->createView()
                ])
            );
        }
        return new RedirectResponse(
            $this->urlGenerator->generate('user_forgot_password')
        );
    }
}
