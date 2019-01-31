<?php

namespace App\UI\Responder;

use App\UI\Responder\Interfaces\TwigRedirectResponderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

/**
 * Class TwigRedirectResponder
 * @package App\UI\Responder
 */
final class TwigRedirectResponder implements TwigRedirectResponderInterface
{
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * TwigRedirectResponder constructor.
     * @inheritdoc
     */
    public function __construct(
        Environment $twig,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(string $view, array $data = []): RedirectResponse
    {
        return new RedirectResponse(
            $this->urlGenerator->generate($view, $data)
        );
    }
}
