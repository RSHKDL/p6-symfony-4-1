<?php

namespace App\Controller\CommentsController;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateCommentsController extends AbstractController
{

    /**
     * @Route("/comment/{figureSlug}/new", methods={"POST"}, name="comments_create")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @ParamConverter("figure", options={"mapping": {"figureSlug": "slug"}})
     *
     * @param Request $request
     * @param Trick $figure
     * @return Response
     * 
     * The ParamConverter mapping is required because the route parameter
     * (figureSlug) doesn't match any of the Doctrine entity properties (slug).
     * See https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html#doctrine-converter
     */
    public function createComments(Request $request, Trick $figure): Response
    {
        $comment = new Comment();
        $comment->setAuthor($this->getUser());
        $figure->addComment($comment);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash('success', 'Comment added successfully');

            return $this->redirectToRoute('trick_view', ['slug' => $figure->getSlug()]);
        }
        return $this->render('figures/_comment_form_errors.html.twig', [
            'figure' => $figure,
            'form' => $form->createView(),
        ]);
    }

    /**
     * This controller is called directly via the render() function in the
     * tricks/view.html.twig template. That's why it's not needed to define
     * a route name for it.
     *
     * The "id" of the Trick is passed in and then turned into a Trick object
     * automatically by the ParamConverter.
     */
    public function renderCommentsForm(Trick $figure): Response
    {
        $form = $this->createForm(CommentType::class);
        return $this->render('figures/_comment_form.html.twig', [
            'figure' => $figure,
            'form' => $form->createView()
        ]);
    }
}
