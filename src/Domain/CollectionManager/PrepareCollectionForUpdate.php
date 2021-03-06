<?php

namespace App\Domain\CollectionManager;

use App\Domain\Builder\Interfaces\ImageBuilderInterface;
use App\Domain\Builder\Interfaces\VideoBuilderInterface;
use App\Domain\CollectionManager\Interfaces\CollectionComparatorInterface;
use App\Domain\CollectionManager\Interfaces\PrepareCollectionForUpdateInterface;
use App\Domain\DTO\Interfaces\ImageDTOInterface;
use App\Domain\Entity\Image;
use App\App\Service\Interfaces\FileRemoverInterface;

final class PrepareCollectionForUpdate implements PrepareCollectionForUpdateInterface
{
    /**
     * @var ImageBuilderInterface
     */
    private $imageBuilder;
    /**
     * @var VideoBuilderInterface
     */
    private $videoBuilder;
    /**
     * @var FileRemoverInterface
     */
    private $fileRemover;
    /**
     * @var CollectionComparatorInterface
     */
    private $collectionComparator;

    /**
     * PrepareCollectionForUpdate constructor.
     * @inheritdoc
     */
    public function __construct(
        ImageBuilderInterface $imageBuilder,
        VideoBuilderInterface $videoBuilder,
        FileRemoverInterface $fileRemover,
        CollectionComparatorInterface $collectionComparator
    ) {
        $this->imageBuilder = $imageBuilder;
        $this->videoBuilder = $videoBuilder;
        $this->fileRemover = $fileRemover;
        $this->collectionComparator = $collectionComparator;
    }

    /**
     * @inheritdoc
     */
    public function prepare(array $collection, array $collectionDTO): array
    {
        if (!empty($collection)) {
            $className = $this->getClassName($collection);
        } else {
            $className = $this->getClassName($collectionDTO);
        }

        $this->collectionComparator->compare($collection, $collectionDTO, $className);

        foreach ($this->collectionComparator->getOldObjects() as $key => $entity) {
            unset($collection[$key]);
            if ($entity instanceof Image) {
                $this->fileRemover->addFileToRemove($entity);
            }
        }

        if ($className === 'Image') {
            foreach ($this->collectionComparator->getNewObjects() as $key => $dto) {
                $collection[$key] = $this->imageBuilder->build($dto, false);
            }
        } elseif ($className === 'Video') {
            foreach ($this->collectionComparator->getNewObjects() as $key => $dto) {
                $collection[$key] = $this->videoBuilder->build($dto, false);
            }
        }

        return $collection;
    }

    /**
     * @param array $collection
     * @return string
     */
    private function getClassName(array $collection): string
    {
        $class = reset($collection);
        if ($class instanceof Image || $class instanceof ImageDTOInterface) {
            return 'Image';
        } else {
            return 'Video';
        }
    }
}
