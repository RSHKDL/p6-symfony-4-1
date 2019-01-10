<?php
/**
 * Created by PhpStorm.
 * User: ereshkidal
 * Date: 10/01/19
 * Time: 12:10
 */

namespace App\Controller\TricksController\Interfaces;

use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

interface IndexTricksControllerInterface
{

    /**
     * IndexTricksControllerInterface constructor.
     * @param TrickRepository $repository
     * @param Environment $environment
     */
    public function __construct(
        TrickRepository $repository,
        Environment $environment
    );

    /**
     * @param int $page
     * @return Response
     * 
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(int $page = 1): Response;
}
