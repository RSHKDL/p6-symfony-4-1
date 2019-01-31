<?php

namespace App\Tests\Controller;

use App\UI\Controller\HomeController;
use App\UI\Controller\Interfaces\HomeControllerInterface;
use App\Domain\Repository\TrickRepository;
use PHPUnit\Framework\TestCase;
use Twig\Environment;

class HomeControllerTest extends TestCase
{
    public function testControllerConstructor()
    {
        $repository = $this->createMock(TrickRepository::class);
        $environment = $this->createMock(Environment::class);

        $controller = new HomeController(
            $repository,
            $environment
        );

        static::assertInstanceOf(
            HomeControllerInterface::class,
            $controller
        );
    }
}
