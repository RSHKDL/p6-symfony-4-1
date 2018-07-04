<?php

namespace App\Controller;


use App\Entity\Figure;
use App\Form\FigureType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class FigController extends Controller
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
     * @Route("/figure/{slug}", name="view_figure")
     * @param $slug
     */
    public function view($slug)
    {
        if (!$slug) {
            throw $this->createNotFoundException('This figure does not exist');
        }

        $figure = $this->getDoctrine()
            ->getRepository(Figure::class)
            ->findOneBy(array('slug' => $slug));

        return $this->render('figures/view.html.twig', [
            'figure' => $figure
        ]);
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

}
