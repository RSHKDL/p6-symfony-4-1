<?php

namespace App\Controller\Interfaces;

use App\Repository\TrickRepository;
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
     * @param TrickRepository $repository
     */
    public function __construct(TrickRepository $repository, Environment $environment);

    /**
     * @return Response
     */
    public function index();
}
