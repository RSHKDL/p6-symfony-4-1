<?php

namespace App\Controller;


use App\Entity\Figure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * @Route("/figures/add")
     */
    public function add()
    {
        return $this->render('figures/add.html.twig');
    }

    /**
     * @Route("/figures/edit/{id}", requirements={"id"="\d+"})
     */
    public function edit()
    {
        return $this->render('figures/edit.html.twig');
    }

    /**
     * @Route("/figures/delete/{id}", requirements={"id"="\d+"})
     */
    public function delete()
    {
        return $this->render('figures/delete.html.twig');
    }

}
