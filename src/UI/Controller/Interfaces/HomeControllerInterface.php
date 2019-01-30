<?php

namespace App\UI\Controller\Interfaces;

use App\Domain\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Interface HomeControllerInterface
 * @package App\UI\Controller\Interfaces
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
