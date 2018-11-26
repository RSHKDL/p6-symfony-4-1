<?php

namespace App\FormHandler;

use App\Entity\Figure;
use App\Entity\User;
use App\Repository\FigureRepository;
use Symfony\Component\Form\FormInterface;

/**
 * Class CreateTrickHandler
 * @package App\FormHandler
 */
final class CreateTrickHandler
{

    /**
     * @var FigureRepository
     */
    private $repository;

    /**
     * CreateTrickHandler constructor.
     * @param FigureRepository $repository
     */
    public function __construct(FigureRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param FormInterface $form
     * @param Figure $figure
     * @param null|User $user
     *
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(FormInterface $form, Figure $figure, User $user = null): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            //$figure->setAuthor($user);
            $this->repository->save($figure);
            return true;
        }
        return false;
    }
}
