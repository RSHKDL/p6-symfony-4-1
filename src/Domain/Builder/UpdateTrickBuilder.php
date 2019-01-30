<?php

namespace App\Domain\Builder;

use App\Domain\Builder\Interfaces\ImageBuilderInterface;
use App\Domain\Builder\Interfaces\UpdateTrickBuilderInterface;
use App\Domain\CollectionManager\Interfaces\PrepareCollectionForUpdateInterface;
use App\Domain\DTO\Interfaces\TrickDTOInterface;
use App\Domain\Entity\Trick;
use App\App\Service\Interfaces\DirectoryModifierInterface;
use App\App\Service\Interfaces\FileRemoverInterface;
use App\App\Service\Interfaces\ImageProcessorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UpdateTrickBuilder implements UpdateTrickBuilderInterface
{
    /**
     * @var ImageProcessorInterface
     */
    private $imageProcessor;
    /**
     * @var ImageBuilderInterface
     */
    private $imageBuilder;
    /**
     * @var FileRemoverInterface
     */
    private $fileRemover;
    /**
     * @var DirectoryModifierInterface
     */
    private $directoryModifier;
    /**
     * @var PrepareCollectionForUpdateInterface
     */
    private $prepareCollectionForUpdate;

    /**
     * UpdateTrickBuilder constructor.
     * @inheritdoc
     */
    public function __construct(
        ImageProcessorInterface $imageProcessor,
        ImageBuilderInterface $imageBuilder,
        FileRemoverInterface $fileRemover,
        DirectoryModifierInterface $directoryModifier,
        PrepareCollectionForUpdateInterface $prepareCollectionForUpdate
    ) {
        $this->imageProcessor = $imageProcessor;
        $this->imageBuilder = $imageBuilder;
        $this->fileRemover = $fileRemover;
        $this->directoryModifier = $directoryModifier;
        $this->prepareCollectionForUpdate = $prepareCollectionForUpdate;
    }

    /**
     * @inheritdoc
     */
    public function update(Trick $trick, TrickDTOInterface $trickDTO): Trick
    {
        $this->imageProcessor->initialize('trick', $trickDTO->name);

        if ($trickDTO->name !== $trick->getName()) {

            $path = $trick->getImageFeatured()->getPath();
            $explodedPath = explode('/', $path);
            $this->fileRemover->getDirectory($explodedPath[3]);

            $updateImageInfo = $this->imageProcessor->getUpdateImageInfo();
            $this->directoryModifier->getDirectoryToModify(
                $trick->getImageFeatured()->getPath(),
                $updateImageInfo['path']
            );

            $trick->getImageFeatured()->setPath($updateImageInfo['path']);
            $trick->getImageFeatured()->setAlt($updateImageInfo['alt']);
            foreach ($trick->getImages() as $image) {
                $image->setPath($updateImageInfo['path']);
                $image->setAlt($updateImageInfo['alt']);
            }
        }

        if ($trickDTO->imageFeatured->file instanceof UploadedFile) {
            $imageFeatured = $this->imageBuilder->build($trickDTO->imageFeatured, false);
            $this->fileRemover->addFileToRemove($trick->getImageFeatured());
        }

        $trick->update(
            $trickDTO->name,
            $trickDTO->description,
            $imageFeatured ?? $trick->getImageFeatured(),
            $this->prepareCollectionForUpdate->prepare($trick->getImages()->toArray(), $trickDTO->images),
            $this->prepareCollectionForUpdate->prepare($trick->getVideos()->toArray(), $trickDTO->videos),
            $trickDTO->categories->toArray()
        );

        return $trick;
    }
}
