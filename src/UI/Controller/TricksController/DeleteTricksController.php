<?php

namespace App\UI\Controller\TricksController;

use App\UI\Controller\TricksController\Interfaces\DeleteTricksControllerInterface;
use App\Domain\Repository\TrickRepository;
use App\UI\Responder\Interfaces\TwigRedirectResponderInterface;
use App\UI\Responder\Interfaces\TwigResponderInterface;
use App\App\Service\Interfaces\DirectoryRemoverInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeleteTricksController
 * @package App\UI\Controller\TricksController
 *
 * @Route("/trick/delete/{id}", name="trick_delete", requirements={"id"="\d+"}, methods={"POST"})
 * @Security("has_role('ROLE_USER')")
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
        $id = $request->attributes->get('id');
        $trick = $this->repository->findOneBy(['id' => $id]);

        /* All tricks except the fixtures have an ImageFeatured */
        if ($trick->getImageFeatured()) {
            $this->remover->removeDirectory($trick->getImageFeatured()->getPath());
        }
        $this->repository->remove($trick);
        $this->flashBag->add('success', 'Trick deleted successfully');

        return $redirectResponder('home');
    }
}
