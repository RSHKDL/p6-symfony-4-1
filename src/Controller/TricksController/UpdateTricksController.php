<?php

namespace App\Controller\TricksController;

use App\Factory\Interfaces\TrickDTOFactoryInterface;
use App\Form\CreateTrickType;
use App\Form\UpdateTrickType;
use App\FormHandler\UpdateTrickHandler;
use App\Repository\TrickRepository;
use App\Responder\Interfaces\TrickResponderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trick/edit/{id}", name="trick_edit", requirements={"id"="\d+"}, methods={"GET", "POST"})
 * @Security("has_role('ROLE_USER')")
 *
 * Class UpdateTricksController
 * @package App\Controller\TricksController
 */
class UpdateTricksController
{

    /**
     * @var TrickRepository
     */
    private $repository;
    /**
     * @var UpdateTrickHandler
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

    public function __construct(
        TrickRepository $repository,
        UpdateTrickHandler $handler,
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
     * @param Request $request
     * @param TrickResponderInterface $responder
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(Request $request, TrickResponderInterface $responder)
    {
        $trick = $this->repository->findOneBy(['id' => $request->attributes->get('id')]);
        $trickDTO = $this->trickDTOFactory->create($trick);
        $form = $this->formFactory->create(UpdateTrickType::class, $trickDTO)->handleRequest($request);

        if ($this->handler->handle($form, $trick)) {
            return $responder('update', true);
        }
        return $responder(
            'update',
            false,
            $form,
            $trick->getSlug() ?? $this->session->get('slug')
        );
    }
}
