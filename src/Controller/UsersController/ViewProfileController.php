<?php

namespace App\Controller\UsersController;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ViewProfileController extends AbstractController
{

    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(
        UserRepository $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * @Route("/profile/{id}", name="user_profile", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function view($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();

        $user = $this->repository->find($id);
        $users = $this->repository->findAll();

        if ($user === null || $currentUser->getId() != $id) {
            throw new AccessDeniedHttpException('Access Denied: You do not have the permission.');
        }

        return $this->render('user/view.html.twig', [
            'user' => $user,
            'users' => $users
        ]);
    }
}
