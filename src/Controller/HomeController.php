<?php

namespace App\Controller;

use App\Entity\Figure;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Figure::class);
        $lastItems = $repo->getLastTricks(3);
        $nbItems = $repo->count([]);

        return $this->render('home/index.html.twig', [
            'items'    => $lastItems,
            'nb_items'      => $nbItems
        ]);
    }
}
