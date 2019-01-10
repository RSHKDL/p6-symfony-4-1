<?php

namespace App\FormHandler\Interfaces;

use App\Builder\Interfaces\UpdateTrickBuilderInterface;
use App\Entity\Trick;
use App\Repository\TrickRepository;
use App\Service\Interfaces\DirectoryModifierInterface;
use App\Service\Interfaces\FileRemoverInterface;
use App\Service\Interfaces\FileUploaderInterface;
use App\Service\Interfaces\SlugMakerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

interface UpdateTrickHandlerInterface
{
    /**
     * UpdateTrickHandlerInterface constructor.
     * @param TrickRepository $repository
     * @param UpdateTrickBuilderInterface $updateTrickBuilder
     * @param FileRemoverInterface $fileRemover
     * @param FileUploaderInterface $fileUploader
     * @param DirectoryModifierInterface $directoryModifier
     * @param SessionInterface $session
     * @param FlashBagInterface $flashBag
     * @param SlugMakerInterface $slugMaker
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
    );

    /**
     * @param FormInterface $form
     * @param Trick $trick
     * @return bool
     */
    public function handle(FormInterface $form, Trick $trick): bool;
}
