<?php

namespace App\FormHandler;

use App\Builder\Interfaces\CreateTrickBuilderInterface;
use App\Entity\Figure;
use App\Repository\FigureRepository;
use App\Service\Interfaces\FileUploaderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @var CreateTrickBuilderInterface
     */
    private $builder;

    /**
     * @var FileUploaderInterface
     */
    private $fileUploader;

    /**
     * @var ValidatorInterface
     */
    private $validator;

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
     * @param FigureRepository $repository
     */
    public function __construct(
        FigureRepository $repository,
        CreateTrickBuilderInterface $builder,
        FileUploaderInterface $fileUploader,
        ValidatorInterface $validator,
        FlashBagInterface $flashBag,
        SessionInterface $session

    ) {
        $this->repository = $repository;
        $this->builder = $builder;
        $this->fileUploader = $fileUploader;
        $this->validator = $validator;
        $this->flashBag = $flashBag;
        $this->session = $session;
    }

    /**
     * @param FormInterface $form
     * @param Figure $trick
     *
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(FormInterface $form): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $trick = $this->builder->build($form->getData());
            $errors = $this->validator->validate($trick, null, ['trick']);
            $this->repository->save($trick);
            $this->fileUploader->uploadFiles();
            $this->session->set('slug', $trick->getSlug());
            $this->flashBag->add('success', 'Trick created successfully');
            return true;
        }
        return false;
    }
}
