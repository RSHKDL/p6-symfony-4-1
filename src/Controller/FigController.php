<?php

namespace App\Controller;


use App\Entity\Figure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $listFigures = $this->getDoctrine()
            ->getRepository(Figure::class)
            ->findAll();
        return $this->render('figures/index.html.twig', [
            'figures' => $listFigures
        ]);
    }

    /**
     * @Route("/figures/{slug}", name="view_figure")
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
     */
    public function add()
    {
        return $this->render('figures/add.html.twig');
    }

    /**
     * @Route("/figures/edit/{id}", name="edit_figure", requirements={"id"="\d+"})
     */
    public function edit($id)
    {
        $item = $this->getDoctrine()
            ->getRepository(Figure::class)
            ->find($id);

        if ($item === null) {
            throw new NotFoundHttpException('Figure '.$id.' does not exist');
        }

        return $this->render('figures/edit.html.twig');
    }

    /**
     * @Route("/figures/delete/{id}", name="delete_figure", requirements={"id"="\d+"})
     */
    public function delete($id)
    {
        $item = $this->getDoctrine()
            ->getRepository(Figure::class)
            ->find($id);

        if ($item === null) {
            throw new NotFoundHttpException('Figure '.$id.' does not exist');
        }
        return $this->render('figures/delete.html.twig');
    }

}
