<?php

namespace App\Controller\TricksController;

use App\Repository\TrickRepository;
use App\Responder\Interfaces\TwigRedirectResponderInterface;
use App\Responder\Interfaces\TwigResponderInterface;
use App\Responder\TwigResponder;
use App\Service\DirectoryRemover;
use App\Service\Interfaces\DirectoryRemoverInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trick/delete/{id}", name="trick_delete", requirements={"id"="\d+"}, methods={"POST"})
 * @Security("has_role('ROLE_USER')")
 *
 * Class DeleteTricksController
 * @package App\Controller\TricksController
 */
class DeleteTricksController
{

    /**
     * @var TrickRepository
     */
    private $repository;

    /**
     * @var DirectoryRemoverInterface
     */
    private $remover;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * DeleteTricksController constructor.
     * @param TrickRepository $repository
     * @param DirectoryRemoverInterface $remover
     * @param FlashBagInterface $flashBag
     */
    public function __construct(
        TrickRepository $repository,
        DirectoryRemoverInterface $remover,
        FlashBagInterface $flashBag
    ) {
        $this->repository = $repository;
        $this->remover = $remover;
        $this->flashBag = $flashBag;
    }

    /**
     * @param Request $request
     * @param TwigRedirectResponderInterface $redirectResponder
     * @param TwigResponderInterface $responder
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(
        Request $request,
        TwigRedirectResponderInterface $redirectResponder,
        TwigResponderInterface $responder
    ) {
        /*$token = $this->token->getValue();
        if ($token !== $request->request->get('token')) {
            return $redirectResponder('trick_view');
        }

        if(!$this->token->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('trick_index');
        }*/

        $token = $request->request->get('token');
        $id = $request->attributes->get('id');
        $trick = $this->repository->findOneBy(['id' => $id]);

        if ($trick->getImageFeatured()) {
            $this->remover->removeDirectory($trick->getImageFeatured()->getPath());
        }
        $this->repository->remove($trick);

        $this->flashBag->set('success', 'Trick deleted successfully');

        return $redirectResponder('home');
    }
}
