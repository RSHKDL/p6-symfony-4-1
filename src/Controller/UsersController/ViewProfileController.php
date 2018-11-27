<?php

namespace App\Controller\UsersController;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ViewProfileController extends AbstractController
{
    /**
     * @Route("/profile/{id}", name="user_profile", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function view($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();

        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->find($id);
        $users = $repo->findAll();

        if ($user === null) {
            throw new NotFoundHttpException('This user does not exist');
        } elseif ($currentUser->getId() != $id){
            throw new AccessDeniedHttpException('You do not have the permission to view other users');
        }

        return $this->render('user/view.html.twig', [
            'user' => $user,
            'users' => $users
        ]);
    }
}
