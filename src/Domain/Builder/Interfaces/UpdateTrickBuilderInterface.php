<?php

namespace App\Domain\Builder\Interfaces;

use App\Domain\CollectionManager\Interfaces\PrepareCollectionForUpdateInterface;
use App\Domain\DTO\Interfaces\TrickDTOInterface;
use App\Domain\Entity\Trick;
use App\App\Service\Interfaces\DirectoryModifierInterface;
use App\App\Service\Interfaces\FileRemoverInterface;
use App\App\Service\Interfaces\ImageProcessorInterface;

interface UpdateTrickBuilderInterface
{
    /**
     * UpdateTrickBuilderInterface constructor.
     * @param ImageProcessorInterface $imageProcessor
     * @param ImageBuilderInterface $imageBuilder
     * @param FileRemoverInterface $fileRemover
     * @param DirectoryModifierInterface $directoryModifier
     * @param PrepareCollectionForUpdateInterface $prepareCollectionForUpdate
     */
    public function __construct(
        ImageProcessorInterface $imageProcessor,
        ImageBuilderInterface $imageBuilder,
        FileRemoverInterface $fileRemover,
        DirectoryModifierInterface $directoryModifier,
        PrepareCollectionForUpdateInterface $prepareCollectionForUpdate
    );

    /**
     * @param Trick $trick
     * @param TrickDTOInterface $trickDTO
     * @return Trick
     */
    public function update(Trick $trick, TrickDTOInterface $trickDTO): Trick;
}
