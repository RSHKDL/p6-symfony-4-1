<?php

namespace App\Tests\Controller;

use App\Controller\HomeController;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomeControllerTest extends KernelTestCase
{
    /**
     * @var TrickRepository
     */
    private $repository;

    /**
     * @var Environment
     */
    private $environment;

    public function setUp()
    {
        static::bootKernel();

        $this->repository = $this->createMock(TrickRepository::class);
        $this->environment = static::$kernel->getContainer()->get('twig');
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testController()
    {
        $controller = new HomeController(
            $this->repository,
            $this->environment
        );

        static::assertInstanceOf(
            Response::class,
            $controller->index()
        );
    }

}