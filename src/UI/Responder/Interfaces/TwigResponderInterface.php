<?php

namespace App\UI\Responder\Interfaces;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Interface TwigResponderInterface
 * @package App\UI\Responder\Interfaces
 */
interface TwigResponderInterface
{
    /**
     * TwigResponderInterface constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig);

    /**
     * @param string $view
     * @param array $data
     * @return Response
     */
    public function __invoke(string $view, array $data): Response;
}
