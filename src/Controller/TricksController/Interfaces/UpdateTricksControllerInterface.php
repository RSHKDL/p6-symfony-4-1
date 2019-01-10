<?php

namespace App\Controller\TricksController\Interfaces;

use App\Factory\Interfaces\TrickDTOFactoryInterface;
use App\FormHandler\Interfaces\UpdateTrickHandlerInterface;
use App\Repository\TrickRepository;
use App\Responder\Interfaces\TrickResponderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

interface UpdateTricksControllerInterface
{
    /**
     * UpdateTricksControllerInterface constructor.
     * @param TrickRepository $repository
     * @param UpdateTrickHandlerInterface $handler
     * @param FormFactoryInterface $formFactory
     * @param TrickDTOFactoryInterface $trickDTOFactory
     * @param SessionInterface $session
     */
    public function __construct(
        TrickRepository $repository,
        UpdateTrickHandlerInterface $handler,
        FormFactoryInterface $formFactory,
        TrickDTOFactoryInterface $trickDTOFactory,
        SessionInterface $session
    );

    /**
     * @param Request $request
     * @param TrickResponderInterface $responder
     *
     * @return RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(Request $request, TrickResponderInterface $responder);

}