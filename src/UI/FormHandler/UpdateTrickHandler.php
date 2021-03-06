<?php

namespace App\UI\FormHandler;

use App\App\Service\Interfaces\DirectoryModifierInterface;
use App\App\Service\Interfaces\FileRemoverInterface;
use App\App\Service\Interfaces\FileUploaderInterface;
use App\App\Service\Interfaces\SlugMakerInterface;
use App\Domain\Builder\Interfaces\UpdateTrickBuilderInterface;
use App\Domain\Entity\Trick;
use App\Domain\Repository\TrickRepository;
use App\UI\FormHandler\Interfaces\UpdateTrickHandlerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class UpdateTrickHandler
 * @package App\FormHandler
 */
final class UpdateTrickHandler implements UpdateTrickHandlerInterface
{
    /**
     * @var TrickRepository
     */
    private $repository;
    /**
     * @var UpdateTrickBuilderInterface
     */
    private $updateTrickBuilder;
    /**
     * @var FileRemoverInterface
     */
    private $fileRemover;
    /**
     * @var FileUploaderInterface
     */
    private $fileUploader;
    /**
     * @var DirectoryModifierInterface
     */
    private $directoryModifier;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;
    /**
     * @var SlugMakerInterface
     */
    private $slugMaker;

    /**
     * UpdateTrickHandler constructor.
     * @inheritdoc
     */
    public function __construct(
        TrickRepository $repository,
        UpdateTrickBuilderInterface $updateTrickBuilder,
        FileRemoverInterface $fileRemover,
        FileUploaderInterface $fileUploader,
        DirectoryModifierInterface $directoryModifier,
        SessionInterface $session,
        FlashBagInterface $flashBag,
        SlugMakerInterface $slugMaker
    ) {
        $this->repository = $repository;
        $this->updateTrickBuilder = $updateTrickBuilder;
        $this->fileRemover = $fileRemover;
        $this->fileUploader = $fileUploader;
        $this->directoryModifier = $directoryModifier;
        $this->session = $session;
        $this->flashBag = $flashBag;
        $this->slugMaker = $slugMaker;
    }

    /**
     * @inheritdoc
     */
    public function handle(FormInterface $form, Trick $trick): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $trick = $this->updateTrickBuilder->update($trick, $form->getData());
            $trick->setSlug($this->slugMaker->slugify($trick->getName(), true));
            $this->repository->save($trick);
            $this->fileUploader->uploadFiles();
            $this->fileRemover->removeFiles();
            $this->directoryModifier->moveFilesToDirectory();
            $this->session->set('slug', $trick->getSlug());
            $this->flashBag->add('success', 'Trick updated successfully');
            return true;
        }
        return false;
    }
}
