<?php

namespace App\UI\Responder\Interfaces;

use App\Domain\Entity\Trick;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

/**
 * Interface TrickResponderInterface
 * @package App\UI\Responder\Interfaces
 */
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
     * @param string|null $slug
     * @param Trick|null $trick
     *
     * @return RedirectResponse|Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(
        string $view,
        bool $redirect = false,
        FormInterface $form = null,
        string $slug = null,
        Trick $trick = null
    );
}