<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class FigController extends Controller
{

    /**
     * @Route("/{page}", name="index_figure", requirements={"page"="\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index($page = 1)
    {
        return $this->render('Figures/index.html.twig');
    }

    /**
     * @Route("/{slug}", name="view_figure")
     * @param $slug
     */
    public function view($slug)
    {
        if (!$slug) {
            throw $this->createNotFoundException('This figure does not exist');
        }
        return $this->render('Figures/view.html.twig');
    }

    /**
     * @Route("/add")
     */
    public function add()
    {
        return $this->render('Figures/add.html.twig');
    }

    /**
     * @Route("/edit/{id}", requirements={"id"="\d+"})
     */
    public function edit()
    {
        return $this->render('Figures/edit.html.twig');
    }

    /**
     * @Route("/delete/{id}", requirements={"id"="\d+"})
     */
    public function delete()
    {
        return $this->render('Figures/delete.html.twig');
    }

}
