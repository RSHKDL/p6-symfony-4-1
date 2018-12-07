<?php

namespace App\Controller\TricksController;

use App\Entity\Trick;
use App\Form\CreateTrickType;
use App\FormHandler\UpdateTrickHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class UpdateTricksController extends AbstractController
{

    /**
     * @var UpdateTrickHandler
     */
    private $handler;
    /**
     * @var Environment
     */
    private $environment;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    public function __construct(
        UpdateTrickHandler $handler,
        Environment $environment,
        FormFactoryInterface $formFactory
    ) {
        $this->handler = $handler;
        $this->environment = $environment;
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/trick/edit/{id}", name="trick_edit", requirements={"id"="\d+"}, methods={"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     *
     * @param Request $request
     * @param Trick $trick
     *
     * @return RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function update(Request $request, Trick $trick)
    {
        $form = $this->formFactory->create(CreateTrickType::class, $trick)->handleRequest($request);

        if ($this->handler->handle($form, $trick)) {

            $this->addFlash('success', 'Trick updated successfully');

            return $this->redirectToRoute('trick_view', [
                'slug' => $trick->getSlug()
            ]);
        }
        return new Response(
            $this->environment->render('figures/edit.html.twig', [
                'form' => $form->createView(),
                'trick' => $trick
            ])
        );
    }
}
