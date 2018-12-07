<?php

namespace App\FormHandler;

use App\Entity\Trick;
use App\Entity\User;
use App\Repository\TrickRepository;
use Symfony\Component\Form\FormInterface;

/**
 * Class UpdateTrickHandler
 * @package App\FormHandler
 */
final class UpdateTrickHandler
{

    /**
     * @var TrickRepository
     */
    private $repository;

    public function __construct(TrickRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param FormInterface $form
     * @param Trick $trick
     * @param User|null $user
     *
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(FormInterface $form, Trick $trick, User $user = null)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->update();
            return true;
        }
        return false;
    }
}
