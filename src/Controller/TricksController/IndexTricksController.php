<?php

namespace App\Controller\TricksController;

use App\Repository\FigureRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class TricksIndexController
 * @package App\Controller\TricksController
 */
class IndexTricksController
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
     * TricksIndexController constructor.
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
     * The paginated Tricks list
     *
     * @Route("/tricks/{page}", name="trick_index", requirements={"page"="\d+"}, methods={"GET"})
     *
     * @param int $page
     *
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(int $page = 1): Response
    {
        if ($page < 1) {
            throw new NotFoundHttpException('Page number '.$page. ' does not exist.');
        }

        $totalItems = $this->repository->count([]);
        $items = $this->repository->getPaginatedTricks($page, 15);
        $totalPages = ceil(count($items) / 15);

        if ($page > $totalPages) {
            throw new NotFoundHttpException('The page '.$page. ' does not exist.');
        }

        return new Response(
            $this->environment->render('figures/index.html.twig', [
                'figures' => $items,
                'nbItems' => $totalItems,
                'nbPages' => $totalPages,
                'page' => $page
            ])
        );
    }
}
