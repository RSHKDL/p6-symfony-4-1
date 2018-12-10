<?php

namespace App\FormHandler;

use App\Builder\Interfaces\CreateTrickBuilderInterface;
use App\Entity\Trick;
use App\Repository\TrickRepository;
use App\Service\Interfaces\FileUploaderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class CreateTrickHandler
 * @package App\FormHandler
 */
final class CreateTrickHandler
{

    /**
     * @var TrickRepository
     */
    private $repository;

    /**
     * @var CreateTrickBuilderInterface
     */
    private $builder;

    /**
     * @var FileUploaderInterface
     */
    private $fileUploader;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * CreateTrickHandler constructor.
     * @param TrickRepository $repository
     */
    public function __construct(
        TrickRepository $repository,
        CreateTrickBuilderInterface $builder,
        FileUploaderInterface $fileUploader,
        FlashBagInterface $flashBag,
        SessionInterface $session

    ) {
        $this->repository = $repository;
        $this->builder = $builder;
        $this->fileUploader = $fileUploader;
        $this->flashBag = $flashBag;
        $this->session = $session;
    }

    /**
     * @param FormInterface $form
     * @param Trick $trick
     *
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(FormInterface $form): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $trick = $this->builder->build($form->getData());
            $this->repository->save($trick);
            $this->fileUploader->uploadFiles();
            $this->session->set('slug', $trick->getSlug());
            $this->flashBag->add('success', 'Trick created successfully');
            return true;
        }
        return false;
    }
}
