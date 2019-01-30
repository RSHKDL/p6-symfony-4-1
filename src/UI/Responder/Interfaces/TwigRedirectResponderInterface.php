<?php

namespace App\UI\Responder\Interfaces;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

interface TwigRedirectResponderInterface
{

    /**
     * TwigResponderInterface constructor.
     *
     * @param Environment $twig
     */
    public function __construct(Environment $twig, UrlGeneratorInterface $urlGenerator);

    /**
     * @param string $view
     * @param array $data
     *
     * @return RedirectResponse
     */
    public function __invoke(string $view, array $data = []): RedirectResponse;
}
