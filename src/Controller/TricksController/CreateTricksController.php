<?php

namespace App\Controller\TricksController;

use App\Form\CreateTrickType;
use App\FormHandler\CreateTrickHandler;
use App\Responder\Interfaces\TrickResponderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CreateTricksController
 * @package App\Controller\TricksController
 *
 * @Route("/trick/create", name="trick_create", methods={"GET", "POST"})
 * @Security("has_role('ROLE_USER')")
 */
final class CreateTricksController
{

    /**
     * @var CreateTrickHandler
     */
    private $handler;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * CreateTricksController constructor.
     * @param CreateTrickHandler $handler
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        CreateTrickHandler $handler,
        FormFactoryInterface $formFactory
    ) {
        $this->handler = $handler;
        $this->formFactory = $formFactory;
    }

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
    public function __invoke(Request $request, TrickResponderInterface $responder): Response
    {
        $form = $this->formFactory->create(CreateTrickType::class)->handleRequest($request);

        if ($this->handler->handle($form)) {
            return $responder('create', true);
        }
        return $responder('create', false, $form);
    }
}
