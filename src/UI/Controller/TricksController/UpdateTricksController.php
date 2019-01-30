<?php

namespace App\UI\Controller\TricksController;

use App\UI\Controller\TricksController\Interfaces\UpdateTricksControllerInterface;
use App\Domain\Factory\Interfaces\TrickDTOFactoryInterface;
use App\UI\Form\UpdateTrickType;
use App\UI\FormHandler\Interfaces\UpdateTrickHandlerInterface;
use App\Domain\Repository\TrickRepository;
use App\UI\Responder\Interfaces\TrickResponderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trick/edit/{id}", name="trick_edit", requirements={"id"="\d+"}, methods={"GET", "POST"})
 * @Security("has_role('ROLE_USER')")
 *
 * Class UpdateTricksController
 * @package App\Controller\TricksController
 */
final class UpdateTricksController implements UpdateTricksControllerInterface
{

    /**
     * @var TrickRepository
     */
    private $repository;
    /**
     * @var UpdateTrickHandlerInterface
     */
    private $handler;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var TrickDTOFactoryInterface
     */
    private $trickDTOFactory;
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * UpdateTricksController constructor.
     * @inheritdoc
     */
    public function __construct(
        TrickRepository $repository,
        UpdateTrickHandlerInterface $handler,
        FormFactoryInterface $formFactory,
        TrickDTOFactoryInterface $trickDTOFactory,
        SessionInterface $session
    ) {
        $this->repository = $repository;
        $this->handler = $handler;
        $this->formFactory = $formFactory;
        $this->trickDTOFactory = $trickDTOFactory;
        $this->session = $session;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(Request $request, TrickResponderInterface $responder)
    {
        $trick = $this->repository->findOneBy(['id' => $request->attributes->get('id')]);
        $trickDTO = $this->trickDTOFactory->create($trick);
        $form = $this->formFactory->create(UpdateTrickType::class, $trickDTO)->handleRequest($request);

        if ($this->handler->handle($form, $trick)) {
            return $responder('update', true, null, null, $trick);
        }
        return $responder(
            'update',
            false,
            $form,
            $trick->getSlug() ?? $this->session->get('slug'),
            $trick
        );
    }
}
