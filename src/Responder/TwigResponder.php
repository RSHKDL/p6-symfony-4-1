<?php

namespace App\Responder;

use App\Responder\Interfaces\TwigResponderInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Class TwigResponder
 * @package App\Responder
 */
class TwigResponder implements TwigResponderInterface
{

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @inheritdoc
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(string $view, array $data): Response
    {
        if (isset($data['form']) && $data['form'] !== null) {
            $data['form'] = $data['form']->createView();
        }
        return new Response(
            $this->twig->render(
                $view,
                $data
            )
        );
    }
}
