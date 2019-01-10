<?php

namespace App\Controller\CommentsController;

use App\Controller\CommentsController\Interfaces\CreateCommentsControllerInterface;
use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateCommentsController extends AbstractController implements CreateCommentsControllerInterface
{

    /**
     * @Route("/comment/{trickSlug}/new", methods={"POST"}, name="comments_create")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @ParamConverter("trick", options={"mapping": {"trickSlug": "slug"}})
     *
     * @param Request $request
     * @param Trick $trick
     * @return Response
     * 
     * The ParamConverter mapping is required because the route parameter
     * (trickSlug) doesn't match any of the Doctrine entity properties (slug).
     * See https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html#doctrine-converter
     */
    public function createComments(Request $request, Trick $trick): Response
    {
        $comment = new Comment();
        $comment->setAuthor($this->getUser());
        $trick->addComment($comment);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash('success', 'Comment added successfully');

            return $this->redirectToRoute('trick_view', ['slug' => $trick->getSlug()]);
        }
        return $this->render('trick/_comment_form_errors.html.twig', [
            'trick' => $trick,
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
    public function renderCommentsForm(Trick $trick): Response
    {
        $form = $this->createForm(CommentType::class);
        return $this->render('trick/_comment_form.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }
}
