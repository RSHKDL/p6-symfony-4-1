<?php

namespace App\Responder\Interfaces;


use App\Entity\Trick;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

interface TrickResponderInterface
{
    /**
     * TrickResponderInterface constructor.
     * @param Environment $twig
     * @param SessionInterface $session
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(Environment $twig, SessionInterface $session, UrlGeneratorInterface $urlGenerator);

    /**
     * @param string $view
     * @param bool $redirect
     * @param FormInterface|null $form
     * @param Trick $trick
     * @param string|null $slug
     *
     * @return RedirectResponse|Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(
        string $view,
        bool $redirect = false,
        Trick $trick,
        FormInterface $form = null,
        string $slug = null
    );
}