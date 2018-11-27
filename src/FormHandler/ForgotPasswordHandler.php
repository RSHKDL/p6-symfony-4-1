<?php

namespace App\FormHandler;

use App\Helper\Interfaces\ForgotPasswordMailInterface;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

final class ForgotPasswordHandler
{

    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var TokenGeneratorInterface
     */
    private $tokenGenerator;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;
    /**
     * @var ForgotPasswordMailInterface
     */
    private $forgotPasswordMail;

    /**
     * ForgotPasswordHandler constructor.
     * @param UserRepository $repository
     * @param TokenGeneratorInterface $tokenGenerator
     * @param FlashBagInterface $flashBag
     * @param ForgotPasswordMailInterface $forgotPasswordMail
     */
    public function __construct(
        UserRepository $repository,
        TokenGeneratorInterface $tokenGenerator,
        FlashBagInterface $flashBag,
        ForgotPasswordMailInterface $forgotPasswordMail
    ) {
        $this->repository = $repository;
        $this->tokenGenerator = $tokenGenerator;
        $this->flashBag = $flashBag;
        $this->forgotPasswordMail = $forgotPasswordMail;
    }

    /**
     * @param FormInterface $form
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(FormInterface $form)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = $this->repository->findOneBy([
                'email' => $data['email']
            ]);

            if ($user) {
                if ($user->getConfirmationToken() == null) {
                    $token = md5(uniqid($user->getUsername(), true));
                    $user->setConfirmationToken($token);
                    $user->setPasswordRequestedAt(new \DateTime());
                    $this->repository->save($user);

                    $this->forgotPasswordMail->createMail($user->getEmail(), $user->getUsername(), $token);
                    $this->flashBag->set('info', 'You will receive an email with further instructions.');

                    return true;
                } else {
                    $this->flashBag->set('danger', 'You have already requested a token.');
                    return false;
                }
            } else {
                $this->flashBag->set('danger', 'This email does not exist in our database.');
            }
        }
        return false;
    }
}
