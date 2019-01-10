<?php

namespace App\Controller\AdminController\Interfaces;

use App\Repository\UserRepository;
use App\Responder\Interfaces\TwigResponderInterface;
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