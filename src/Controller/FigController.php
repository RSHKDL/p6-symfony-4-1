<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Figure;
use App\Form\CommentType;
use App\Form\FigureType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
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
        return $this->render('figures/view.html.twig', ['figure' => $figure]);
    }

    /**
     * @Route("/figures/add", name="add_figure")
     * @Security("has_role('ROLE_USER')")
     */
    public function add(Request $request)
    {
        $figure = new Figure();
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($figure);
            $manager->flush();

            return $this->redirectToRoute('view_figure', array(
                'slug' => $figure->getSlug()
            ));
        }

        return $this->render('figures/add.html.twig', [
            'form' => $form->createView()
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
            throw new NotFoundHttpException('Figure '.$id.' does not exist');
        }

        $form = $this->createForm(FigureType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($item);
            $manager->flush();

            return $this->redirectToRoute('view_figure', array(
                'slug' => $item->getSlug()
            ));
        }

        return $this->render('figures/edit.html.twig', [
            'form' => $form->createView()
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

            return $this->redirectToRoute('view_figure', ['slug' => $figure->getSlug()]);
        }
        return $this->render('figures/_comment_form_error.html.twig', [
            'figure' => $figure,
            'form' => $form->createView(),
        ]);
    }
    /**
     * This controller is called directly via the render() function in the
     * blog/post_show.html.twig template. That's why it's not needed to define
     * a route name for it.
     *
     * The "id" of the Post is passed in and then turned into a Post object
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

}
