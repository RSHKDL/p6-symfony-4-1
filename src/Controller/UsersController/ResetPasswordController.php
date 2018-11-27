<?php

namespace App\Controller\UsersController;

use App\Form\ChangePasswordType;
use App\FormHandler\ResetPasswordHandler;
use App\Repository\UserRepository;
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
final class ResetPasswordController
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
     * @Route("/user/reset-password/{token}", name="user_reset_password", methods={"GET", "POST"})
     *
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
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
