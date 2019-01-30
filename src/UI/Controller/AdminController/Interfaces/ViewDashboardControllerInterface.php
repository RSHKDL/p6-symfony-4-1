<?php

namespace App\UI\Controller\AdminController\Interfaces;

use App\Domain\Repository\UserRepository;
use App\UI\Responder\Interfaces\TwigResponderInterface;
use Symfony\Component\HttpFoundation\Response;

interface ViewDashboardControllerInterface
{

    /**
     * ViewDashboardControllerInterface constructor.
     * @param UserRepository $repository
     */
    public function __construct(
        UserRepository $repository
    );

    /**
     * @param TwigResponderInterface $responder
     * @return Response
     */
    public function __invoke(TwigResponderInterface $responder): Response;
}