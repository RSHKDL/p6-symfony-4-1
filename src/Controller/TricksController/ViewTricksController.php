<?php

namespace App\Controller\TricksController;

use App\Controller\TricksController\Interfaces\ViewTricksControllerInterface;
use App\Entity\Trick;
use App\Repository\TrickRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class TricksViewController
 * @package App\Controller\TricksController
 */
final class ViewTricksController implements ViewTricksControllerInterface
{

    /**
     * @var TrickRepository
     */
    private $repository;
    /**
     * @var Environment
     */
    private $environment;

    /**
     * TricksViewController constructor.
     * @inheritdoc
     */
    public function __construct(
        TrickRepository $repository,
        Environment $environment
    ) {
        $this->repository = $repository;
        $this->environment = $environment;
    }

    /**
     * Display a Trick
     *
     * @Route("/trick/{slug}", methods={"GET"}, name="trick_view")
     * @inheritdoc
     */
    public function view(Trick $trick): Response
    {
        $length = 5;
        /** @var Collection $comments */
        $comments = $trick->getComments();

        return new Response(
            $this->environment->render('trick/view.html.twig', [
                'trick'             => $trick,
                'comments'          => $comments->slice(0,$length),
                'total_comments'    => $comments->count(),
                'length'            => $length
            ])
        );
    }
}
