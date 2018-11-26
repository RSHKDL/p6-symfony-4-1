<?php

namespace App\Controller\TricksController;

use App\Entity\Figure;
use App\Form\FigureType;
use App\FormHandler\CreateTrickHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

final class CreateTricksController
{

    /**
     * @var Environment
     */
    private $environment;
    /**
     * @var CreateTrickHandler
     */
    private $handler;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * TricksCreateController constructor.
     * @param CreateTrickHandler $handler
     * @param FormFactoryInterface $formFactory
     * @param Environment $environment
     */
    public function __construct(
        CreateTrickHandler $handler,
        FormFactoryInterface $formFactory,
        Environment $environment,
        UrlGeneratorInterface $urlGenerator,
        FlashBagInterface $flashBag
    ) {
        $this->environment = $environment;
        $this->handler = $handler;
        $this->formFactory = $formFactory;
        $this->urlGenerator = $urlGenerator;
        $this->flashBag = $flashBag;
    }

    /**
     * @Route("/trick/create", name="trick_create", methods={"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     *
     * @param Request $request
     *
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function create(Request $request): Response
    {
        $figure = new Figure();
        $form = $this->formFactory->create(FigureType::class, $figure)->handleRequest($request);

        if ($this->handler->handle($form, $figure)) {

            $this->flashBag->add('success', 'Trick created successfully');

            return new RedirectResponse(
                $this->urlGenerator->generate('trick_view', [
                    'slug' => $figure->getSlug()
                ])
            );
        }
        return new Response(
            $this->environment->render('figures/add.html.twig', [
                'form' => $form->createView(),
                'trick' => null
            ])
        );
    }
}
