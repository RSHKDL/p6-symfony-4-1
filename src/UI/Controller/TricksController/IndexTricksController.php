<?php

namespace App\UI\Controller\TricksController;

use App\UI\Controller\TricksController\Interfaces\IndexTricksControllerInterface;
use App\Domain\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class TricksIndexController
 * @package App\Controller\TricksController
 */
final class IndexTricksController implements IndexTricksControllerInterface
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
     * TricksIndexController constructor.
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
     * The paginated Tricks list
     *
     * @Route("/tricks/{page}", name="trick_index", requirements={"page"="\d+"}, methods={"GET"})
     * @inheritdoc
     */
    public function index(int $page = 1): Response
    {
        if ($page < 1) {
            throw new NotFoundHttpException('Page number '.$page. ' does not exist.');
        }

        $totalItems = $this->repository->count([]);
        $items = $this->repository->getPaginatedTricks($page, 6);
        $totalPages = ceil(count($items) / 6);

        /*if ($page > $totalPages) {
            throw new NotFoundHttpException('The page '.$page. ' does not exist.');
        }*/

        return new Response(
            $this->environment->render('trick/index.html.twig', [
                'tricks' => $items,
                'nbItems' => $totalItems,
                'nbPages' => $totalPages,
                'page' => $page
            ])
        );
    }
}
