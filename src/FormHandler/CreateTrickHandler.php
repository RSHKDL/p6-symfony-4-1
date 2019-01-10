<?php

namespace App\FormHandler;

use App\Builder\Interfaces\CreateTrickBuilderInterface;
use App\Entity\Trick;
use App\FormHandler\Interfaces\CreateTrickHandlerInterface;
use App\Repository\TrickRepository;
use App\Service\Interfaces\FileUploaderInterface;
use App\Service\Interfaces\SlugMakerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class CreateTrickHandler
 * @package App\FormHandler
 */
final class CreateTrickHandler implements CreateTrickHandlerInterface
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
     * @var SlugMakerInterface
     */
    private $slugMaker;

    /**
     * CreateTrickHandler constructor.
     * @inheritdoc
     */
    public function __construct(
        TrickRepository $repository,
        CreateTrickBuilderInterface $builder,
        FileUploaderInterface $fileUploader,
        FlashBagInterface $flashBag,
        SessionInterface $session,
        SlugMakerInterface $slugMaker

    ) {
        $this->repository = $repository;
        $this->builder = $builder;
        $this->fileUploader = $fileUploader;
        $this->flashBag = $flashBag;
        $this->session = $session;
        $this->slugMaker = $slugMaker;
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
            $trick->setSlug($this->slugMaker->slugify($trick->getName(), true));
            $this->repository->save($trick);
            $this->fileUploader->uploadFiles();
            $this->session->set('slug', $trick->getSlug());
            $this->flashBag->add('success', 'Trick created successfully');
            return true;
        }
        return false;
    }
}
