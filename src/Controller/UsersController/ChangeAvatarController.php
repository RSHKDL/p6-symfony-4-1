<?php

namespace App\Controller\UsersController;

use App\Controller\UsersController\Interfaces\ChangeAvatarControllerInterface;
use App\Entity\User;
use App\Form\ChangeAvatarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ChangeAvatarController extends AbstractController implements ChangeAvatarControllerInterface
{

    /**
     * @inheritdoc
     */
    public function changeAvatar(Request $request, User $user)
    {
        $form = $this->createForm(ChangeAvatarType::class, $user)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $avatar = 'test';
            $user->setPassword($avatar);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Avatar modified successfully');

            return $this->redirectToRoute('user_profile', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('user/_change_avatar_form_errors.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function renderForm(User $user): Response
    {
        $form = $this->createForm(ChangeAvatarType::class);
        return $this->render('user/_change_avatar_form.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}
