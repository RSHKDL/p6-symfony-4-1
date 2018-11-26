<?php

namespace App\Controller\Interfaces;

use App\Repository\FigureRepository;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Interface HomeControllerInterface
 * @package App\Controller\Interfaces
 */
interface HomeControllerInterface
{

    /**
     * HomeControllerInterface constructor.
     * @param FigureRepository $repository
     */
    public function __construct(FigureRepository $repository, Environment $environment);

    /**
     * @return Response
     */
    public function index();
}
