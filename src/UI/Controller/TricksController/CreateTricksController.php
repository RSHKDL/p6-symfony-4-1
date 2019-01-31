<?php

namespace App\UI\Controller\TricksController;

use App\UI\Controller\TricksController\Interfaces\CreateTricksControllerInterface;
use App\UI\Form\CreateTrickType;
use App\UI\FormHandler\Interfaces\CreateTrickHandlerInterface;
use App\UI\Responder\Interfaces\TrickResponderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CreateTricksController
 * @package App\UI\Controller\TricksController
 *
 * @Route("/trick/create", name="trick_create", methods={"GET", "POST"})
 * @Security("has_role('ROLE_USER')")
 */
final class CreateTricksController implements CreateTricksControllerInterface
{

    /**
     * @var CreateTrickHandlerInterface
     */
    private $handler;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * CreateTricksController constructor.
     * @inheritdoc
     */
    public function __construct(
        CreateTrickHandlerInterface $handler,
        FormFactoryInterface $formFactory
    ) {
        $this->handler = $handler;
        $this->formFactory = $formFactory;
    }

    /**
     * @inheritdoc
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
