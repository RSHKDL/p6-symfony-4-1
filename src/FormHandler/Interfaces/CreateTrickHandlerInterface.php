<?php

namespace App\FormHandler\Interfaces;

use App\Builder\Interfaces\CreateTrickBuilderInterface;
use App\Repository\TrickRepository;
use App\Service\Interfaces\FileUploaderInterface;
use App\Service\Interfaces\SlugMakerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

interface CreateTrickHandlerInterface
{

    /**
     * CreateTrickHandlerInterface constructor.
     * @param TrickRepository $repository
     * @param CreateTrickBuilderInterface $builder
     * @param FileUploaderInterface $fileUploader
     * @param FlashBagInterface $flashBag
     * @param SessionInterface $session
     * @param SlugMakerInterface $slugMaker
     */
    public function __construct(
        TrickRepository $repository,
        CreateTrickBuilderInterface $builder,
        FileUploaderInterface $fileUploader,
        FlashBagInterface $flashBag,
        SessionInterface $session,
        SlugMakerInterface $slugMaker
    );

    /**
     * @param FormInterface $form
     * @return bool
     */
    public function handle(FormInterface $form): bool;
}
