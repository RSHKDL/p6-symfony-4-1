<?php

namespace App\UI\Controller\TricksController\Interfaces;

use App\UI\FormHandler\Interfaces\CreateTrickHandlerInterface;
use App\UI\Responder\Interfaces\TrickResponderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface CreateTricksControllerInterface
{

    /**
     * CreateTricksControllerInterface constructor.
     * @param CreateTrickHandlerInterface $handler
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        CreateTrickHandlerInterface $handler,
        FormFactoryInterface $formFactory
    );

    /**
     * @param Request $request
     * @param TrickResponderInterface $responder
     *
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(
        Request $request,
        TrickResponderInterface $responder
    ): Response;
}
