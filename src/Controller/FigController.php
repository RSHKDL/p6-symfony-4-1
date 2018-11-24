<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Figure;
use App\Form\CommentType;
use App\Form\FigureType;
use Doctrine\Common\Collections\Collection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class FigController extends AbstractController
{

    /**
     * @Route("/figures/{page}", name="index_figure", requirements={"page"="\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index($page = 1)
    {
        if ($page < 1) {
            throw new NotFoundHttpException('The page '.$page. ' does not exist.');
        }

        $nbPerPage = 15;
        $repo = $this->getDoctrine()->getRepository(Figure::class);
        $nbItems = $repo->count([]);

        $listItems = $repo->getFigures($page, $nbPerPage);

        $nbPages = ceil(count($listItems) / $nbPerPage);

        if ($page > $nbPages) {
            throw new NotFoundHttpException('The page '.$page. ' does not exist.');
        }

        return $this->render('figures/index.html.twig', [
            'figures' => $listItems,
            'nbItems' => $nbItems,
            'nbPages' => $nbPages,
            'page' => $page
        ]);
    }

    /**
     * @Route("/figure/{slug}", methods={"GET"}, name="view_figure")
     */
    public function view(Figure $figure): Response
    {
        $comments = $figure->getComments()->slice(0,3);
        $totalComments = $figure->getComments()->count();

        return $this->render('figures/view.html.twig', [
            'figure' => $figure,
            'comments' => $comments,
            'total_comments' => $totalComments
        ]);
    }

    /**
     * @Route("/figures/add", name="add_figure")
     * @Security("has_role('ROLE_USER')")
     */
    public function add(Request $request): Response
    {
        $figure = new Figure();
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($figure);
            $manager->flush();

            $this->addFlash('success', 'Trick created successfully');

            return $this->redirectToRoute('view_figure', array(
                'slug' => $figure->getSlug()
            ));
        }

        return $this->render('figures/add.html.twig', [
            'form' => $form->createView(),
            'trick' => null
        ]);
    }

    /**
     * @Route("/figure/edit/{id}", name="edit_figure", requirements={"id"="\d+"})
     */
    public function edit($id, Request $request)
    {
        $item = $this->getDoctrine()
            ->getRepository(Figure::class)
            ->find($id);

        if ($item === null) {
            throw new NotFoundHttpException('Trick '.$id.' does not exist');
        }

        $form = $this->createForm(FigureType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($item);
            $manager->flush();

            $this->addFlash('success', 'Trick updated successfully');

            return $this->redirectToRoute('view_figure', array(
                'slug' => $item->getSlug()
            ));
        }

        return $this->render('figures/edit.html.twig', [
            'form' => $form->createView(),
            'trick' => $item
        ]);
    }

    /**
     * @Route("/figure/delete/{id}",
     *  name="delete_figure",
     *  requirements={"id"="\d+"}),
     *  methods={"POST"}
     */
    public function delete(Request $request, Figure $figure): Response
    {
        if(!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('index_figure');
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($figure);
        $manager->flush();

        $this->addFlash('success', 'Trick deleted successfully');

        return $this->redirectToRoute('index_figure');
    }

    /**
     * @Route("/comment/{figureSlug}/new", methods={"POST"}, name="comment_new")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @ParamConverter("figure", options={"mapping": {"figureSlug": "slug"}})
     *
     * The ParamConverter mapping is required because the route parameter
     * (figureSlug) doesn't match any of the Doctrine entity properties (slug).
     * See https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html#doctrine-converter
     */
    public function commentNew(Request $request, Figure $figure): Response
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

            return $this->redirectToRoute('view_figure', ['slug' => $figure->getSlug()]);
        }
        return $this->render('figures/_comment_form_errors.html.twig', [
            'figure' => $figure,
            'form' => $form->createView(),
        ]);
    }

    /**
     * This controller is called directly via the render() function in the
     * Trick_show.html.twig template. That's why it's not needed to define
     * a route name for it.
     *
     * The "id" of the Trick is passed in and then turned into a Trick object
     * automatically by the ParamConverter.
     */
    public function commentForm(Figure $figure): Response
    {
        $form = $this->createForm(CommentType::class);
        return $this->render('figures/_comment_form.html.twig', [
            'figure' => $figure,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/figure/{id}/comment",
     *     methods={"POST"},
     *     name="display_comment",
     *     requirements={"id"="\d+"}
     *     )
     */
    public function commentDisplay(Request $request, int $id)
    {
        if($request->isXmlHttpRequest()) {
            $offset = $request->request->get('offset');
            /*$repo = $this->getDoctrine()->getRepository(Comment::class);
            $batch = $repo->getCommentsBatch($id, 3, $offset);*/

            $figure = $this->getDoctrine()->getRepository(Figure::class)->find($id);
            /** @var Collection $comments */
            $comments = $figure->getComments();

            $batch = [];
            foreach($comments->slice($offset,3) as $comment) {
                $batch[] = [
                    'id' => $comment->getId(),
                    'content' => $comment->getContent(),
                ];
            }

            $data = [
                'batch' => $batch,
                'offset' => $offset+3
            ];
            return new JsonResponse($data);
        }
        return new JsonResponse('No results');
    }
}
