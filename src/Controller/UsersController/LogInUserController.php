<?php

namespace App\Controller\UsersController;

use App\Controller\UsersController\Interfaces\LogInUserControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class LogInUserController
 * @package App\Controller\UsersController
 * 
 * Get the login error if there is one and
 * the last username entered by the user 
 * with AuthenticationUtils
 */
final class LogInUserController extends AbstractController implements LogInUserControllerInterface
{

    /**
     * @inheritdoc
     * @Route("/login", name="user_login", methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error
        ));
    }
}
