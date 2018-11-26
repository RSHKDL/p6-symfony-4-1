<?php

namespace App\FormHandler;

use App\Entity\Figure;
use App\Entity\User;
use App\Repository\FigureRepository;
use Symfony\Component\Form\FormInterface;

/**
 * Class UpdateTrickHandler
 * @package App\FormHandler
 */
final class UpdateTrickHandler
{

    /**
     * @var FigureRepository
     */
    private $repository;

    public function __construct(FigureRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param FormInterface $form
     * @param Figure $figure
     * @param User|null $user
     *
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(FormInterface $form, Figure $figure, User $user = null)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->update();
            return true;
        }
        return false;
    }
}
