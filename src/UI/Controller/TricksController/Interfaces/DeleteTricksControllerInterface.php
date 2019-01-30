<?php

namespace App\UI\Controller\TricksController\Interfaces;

use App\Domain\Repository\TrickRepository;
use App\UI\Responder\Interfaces\TwigRedirectResponderInterface;
use App\UI\Responder\Interfaces\TwigResponderInterface;
use App\App\Service\Interfaces\DirectoryRemoverInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

interface DeleteTricksControllerInterface
{

    /**
     * DeleteTricksControllerInterface constructor.
     * @param TrickRepository $repository
     * @param DirectoryRemoverInterface $remover
     * @param FlashBagInterface $flashBag
     */
    public function __construct(
        TrickRepository $repository,
        DirectoryRemoverInterface $remover,
        FlashBagInterface $flashBag
    );

    /**
     * @param Request $request
     * @param TwigRedirectResponderInterface $redirectResponder
     * @param TwigResponderInterface $responder
     *
     * @return RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(
        Request $request,
        TwigRedirectResponderInterface $redirectResponder,
        TwigResponderInterface $responder
    );
}
