<?php

namespace App\Controller\TricksController;

use App\Entity\Figure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteTricksController extends AbstractController
{

    /**
     * @Route("/trick/delete/{id}", name="trick_delete", requirements={"id"="\d+"}, methods={"POST"})
     * @Security("has_role('ROLE_USER')")
     *
     * @param Request $request
     * @param Figure $trick
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Request $request, Figure $trick)
    {
        if(!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('trick_index');
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($trick);
        $manager->flush();

        $this->addFlash('success', 'Trick deleted successfully');

        return $this->redirectToRoute('trick_index');
    }
}
