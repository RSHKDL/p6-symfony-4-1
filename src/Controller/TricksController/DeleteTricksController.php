<?php

namespace App\Controller\TricksController;

use App\Controller\TricksController\Interfaces\DeleteTricksControllerInterface;
use App\Repository\TrickRepository;
use App\Responder\Interfaces\TwigRedirectResponderInterface;
use App\Responder\Interfaces\TwigResponderInterface;
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
final class DeleteTricksController implements DeleteTricksControllerInterface
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
     * @inheritdoc
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
     * @inheritdoc
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
