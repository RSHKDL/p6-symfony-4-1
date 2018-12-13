<?php

namespace App\CollectionManager;

use App\CollectionManager\Interfaces\CollectionComparatorInterface;
use App\DTO\Interfaces\ImageDTOInterface;
use App\DTO\Interfaces\VideoDTOInterface;
use App\Entity\Image;
use App\Entity\Video;

final class CollectionComparator implements CollectionComparatorInterface
{
    /**
     * @var array
     */
    private $newObjects = [];

    /**
     * @var array
     */
    private $oldObjects = [];

    /**
     * @inheritdoc
     */
    public function compare(array $collection, array $collectionDTO, string $className): void
    {
        $isDifferent = 'is'.$className.'Different';

        foreach ($collectionDTO as $key => $value) {
            if (array_key_exists($key, $collection)) {
                if ($this->$isDifferent($collection[$key], $value)) {
                    $this->oldObjects[$key] = $collection[$key];
                    $this->newObjects[$key] = $value;
                }
            } else {
                $this->newObjects[$key] = $value;
            }
        }

        foreach ($collection as $key => $value) {
            if (!array_key_exists($key, $collectionDTO)) {
                $this->oldObjects[$key] = $value;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function getNewObjects(): array
    {
        $newObjects = $this->newObjects;
        $this->newObjects = [];

        return $newObjects;
    }

    /**
     * @inheritdoc
     */
    public function getOldObjects(): array
    {
        $oldObjects = $this->oldObjects;
        $this->oldObjects = [];

        return $oldObjects;
    }

    /**
     * @param Image $image
     * @param ImageDTOInterface $imageDTO
     * @return bool
     */
    private function isImageDifferent(Image $image, ImageDTOInterface $imageDTO): bool
    {
        $imageDTO->file->getFilename() !== $image->getName() ? $result = true : $result = false;
        return $result;
    }

    /**
     * @param Video $video
     * @param VideoDTOInterface $videoDTO
     * @return bool
     */
    private function isVideoDifferent(Video $video, VideoDTOInterface $videoDTO): bool
    {
        $videoDTO->rawUrl !== $video->getRawUrl() ? $result = true : $result = false;
        return $result;
    }
}
