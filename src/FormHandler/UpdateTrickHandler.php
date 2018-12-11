<?php

namespace App\FormHandler;

use App\Builder\Interfaces\UpdateTrickBuilderInterface;
use App\Entity\Trick;
use App\FormHandler\Interfaces\UpdateTrickHandlerInterface;
use App\Repository\TrickRepository;
use App\Service\Interfaces\DirectoryModifierInterface;
use App\Service\Interfaces\FileRemoverInterface;
use App\Service\Interfaces\FileUploaderInterface;
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
        FlashBagInterface $flashBag
    ) {
        $this->repository = $repository;
        $this->updateTrickBuilder = $updateTrickBuilder;
        $this->fileRemover = $fileRemover;
        $this->fileUploader = $fileUploader;
        $this->directoryModifier = $directoryModifier;
        $this->session = $session;
        $this->flashBag = $flashBag;
    }

    /**
     * @inheritdoc
     */
    public function handle(FormInterface $form, Trick $trick): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $trick = $this->updateTrickBuilder->update($trick, $form->getData());
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
