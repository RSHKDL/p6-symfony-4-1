<?php

namespace App\Controller;

use App\Controller\Interfaces\HomeControllerInterface;
use App\Entity\Figure;
use App\Repository\FigureRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Twig\Environment;
use Twig_Error_Loader;
use Twig_Error_Runtime;
use Twig_Error_Syntax;

final class HomeController implements HomeControllerInterface
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
     * HomeControllerInterface constructor.
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
     * @Route("/", name="home", methods={"GET"})
     *
     * @return Response
     *
     * @throws Twig_Error_Loader  When the template cannot be found
     * @throws Twig_Error_Syntax  When an error occurred during compilation
     * @throws Twig_Error_Runtime When an error occurred during rendering
     */
    public function index(): Response
    {
        $lastItems = $this->repository->getLastTricks(3);
        $nbItems = $this->repository->count([]);

        return new Response(
            $this->environment->render('home/index.html.twig', [
                'items'    => $lastItems,
                'nb_items'      => $nbItems
            ])
        );
    }
}
