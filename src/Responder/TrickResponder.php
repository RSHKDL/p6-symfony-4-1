<?php

namespace App\Responder;

use App\Entity\Trick;
use App\Responder\Interfaces\TrickResponderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

final class TrickResponder implements TrickResponderInterface
{
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @inheritdoc
     */
    public function __construct(
        Environment $twig,
        SessionInterface $session,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->twig = $twig;
        $this->session = $session;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(
        string $view,
        bool $redirect = false,
        FormInterface $form = null,
        string $slug = null,
        Trick $trick = null
    ) {
        if ($redirect) {
            $response = new RedirectResponse(
                $this->urlGenerator->generate('trick_view', ['slug' => $this->session->get('slug')])
            );
        } else {
            $response = new Response(
                $this->twig->render('trick/'.$view.'.html.twig', [
                    'form'  => $form->createView(),
                    'trick' => $trick,
                    'slug'  => $slug
                ]));
        }
        return $response;
    }
}
