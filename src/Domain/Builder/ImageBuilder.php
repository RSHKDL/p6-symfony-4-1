<?php

namespace App\Domain\Builder;

use App\Domain\Builder\Interfaces\ImageBuilderInterface;
use App\Domain\DTO\Interfaces\ImageDTOInterface;
use App\Domain\Entity\Image;
use App\App\Service\Interfaces\FileUploaderInterface;
use App\App\Service\Interfaces\ImageProcessorInterface;

final class ImageBuilder implements ImageBuilderInterface
{

    /**
     * @var ImageProcessorInterface
     */
    private $imageProcessor;

    /**
     * @var FileUploaderInterface
     */
    private $uploader;

    /**
     * ImageBuilder constructor.
     * @param ImageProcessorInterface $processor
     * @param FileUploaderInterface $uploader
     */
    public function __construct(
        ImageProcessorInterface $processor,
        FileUploaderInterface $uploader
    ) {
        $this->imageProcessor = $processor;
        $this->uploader = $uploader;
    }

    /**
     * @param $imagesDTO
     * @param bool $isCollection
     * @return Image|array
     */
    public function build($imagesDTO, bool $isCollection)
    {
        if($isCollection) {
            $images = [];
            foreach ($imagesDTO as $imageDTO) {
                if($imageDTO->file !== null) {
                    $images[] = $this->createImage($imageDTO);
                }
            }
            return $images;
        }
        return $this->createImage($imagesDTO);
    }

    /**
     * @param ImageDTOInterface $imageDTO
     * @return Image
     */
    private function createImage(ImageDTOInterface $imageDTO): Image
    {
        $imageInfo = $this->imageProcessor->generateImageInfo($imageDTO->file);

        $this->uploader->addFileToUpload(
            $imageDTO->file,
            $imageInfo['filename'],
            $imageInfo['path']

        );

        return new Image(
            $imageInfo['filename'],
            $imageInfo['path'],
            $imageInfo['alt']
        );
    }
}
