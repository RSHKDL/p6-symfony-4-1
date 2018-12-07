<?php

namespace App\Controller\TricksController;

use App\Entity\Trick;
use App\Repository\FigureRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class TricksViewController
 * @package App\Controller\TricksController
 */
class ViewTricksController
{

    /**
     * @var FigureRepository
     */
    private $repository;
    /**
     * @var Environment
     */
    private $environment;

    /**
     * TricksViewController constructor.
     * @param FigureRepository $repository
     * @param Environment $environment
     */
    public function __construct(
        FigureRepository $repository,
        Environment $environment
    ) {
        $this->repository = $repository;
        $this->environment = $environment;
    }

    /**
     * Display a Trick
     *
     * @Route("/trick/{slug}", methods={"GET"}, name="trick_view")
     *
     * @param Trick $trick
     *
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function view(Trick $trick): Response
    {
        $comments = $trick->getComments()->slice(0,3);
        $totalComments = $trick->getComments()->count();

        return new Response(
            $this->environment->render('figures/view.html.twig', [
                'trick' => $trick,
                'comments' => $comments,
                'total_comments' => $totalComments
            ])
        );
    }
}
