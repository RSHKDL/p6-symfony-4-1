<?php

namespace App\Controller\UsersController;

use App\Controller\UsersController\Interfaces\ViewProfileControllerInterface;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

final class ViewProfileController extends AbstractController implements ViewProfileControllerInterface
{

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * ViewProfileController constructor.
     * @inheritdoc
     */
    public function __construct(
        UserRepository $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * @inheritdoc
     * @Route("/profile/{id}", 
     *     name="user_profile", 
     *     requirements={"id"="\d+"}, 
     *     methods={"GET", "POST"}
     * )
     */
    public function view(int $id)
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
