<?php

namespace App\Controller\UsersController;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class ChangePasswordController extends AbstractController
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/profile/{id}/change-password", methods={"POST"}, name="user_profile_change_password")
     *
     * @param Request $request
     * @param User $user
     */
    public function changePassword(Request $request, User $user)
    {
        $form = $this->createForm(ChangePasswordType::class, $user)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->passwordEncoder->encodePassword($user, $form->getData()->getPlainPassword());
            $user->setPassword($password);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Password modified successfully');

            return $this->redirectToRoute('user_profile', [
                'id' => $user->getId()
            ]);
        }
        return $this->render('user/_change_password_form_errors.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    public function renderForm(User $user): Response
    {
        $form = $this->createForm(ChangePasswordType::class);
        return $this->render('user/_change_password_form.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}
