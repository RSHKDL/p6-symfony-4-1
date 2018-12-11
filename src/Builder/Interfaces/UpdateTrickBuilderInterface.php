<?php

namespace App\Builder\Interfaces;

use App\CollectionManager\Interfaces\PrepareCollectionForUpdateInterface;
use App\DTO\Interfaces\TrickDTOInterface;
use App\Entity\Trick;
use App\Service\Interfaces\DirectoryModifierInterface;
use App\Service\Interfaces\FileRemoverInterface;
use App\Service\Interfaces\ImageProcessorInterface;

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
