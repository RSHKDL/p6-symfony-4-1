<?php

namespace App\Builder;

use App\Builder\Interfaces\CreateTrickBuilderInterface;
use App\Builder\Interfaces\ImageBuilderInterface;
use App\Builder\Interfaces\VideoBuilderInterface;
use App\DTO\Interfaces\TrickDTOInterface;
use App\Entity\Trick;
use App\Entity\User;
use App\Service\Interfaces\ImageProcessorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class CreateTrickBuilder implements CreateTrickBuilderInterface
{

    /**
     * @var User
     */
    private $user;

    /**
     * @var ImageProcessorInterface
     */
    private $imageProcessor;

    /**
     * @var ImageBuilderInterface
     */
    private $imageBuilder;

    /**
     * @var VideoBuilderInterface
     */
    private $videoBuilder;


    /**
     * @inheritdoc
     */
    public function __construct(
        ImageProcessorInterface $imageProcessor,
        ImageBuilderInterface $imageBuilder,
        VideoBuilderInterface $videoBuilder,
        TokenStorageInterface $tokenStorage
    ) {
        $this->user = $tokenStorage->getToken()->getUser();
        $this->imageProcessor = $imageProcessor;
        $this->imageBuilder = $imageBuilder;
        $this->videoBuilder = $videoBuilder;
    }

    /**
     * @inheritdoc
     */
    public function build(TrickDTOInterface $trickDTO)
    {
        $this->imageProcessor->initialize('trick', $trickDTO->name);

        return new Trick(
            $trickDTO->name,
            $trickDTO->description,
            $this->user,
            $this->imageBuilder->build($trickDTO->imageFeatured, false),
            $this->imageBuilder->build($trickDTO->images, true),
            $this->videoBuilder->build($trickDTO->videos, true),
            $trickDTO->categories
        );
    }
}
