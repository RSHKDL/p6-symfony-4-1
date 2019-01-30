<?php

namespace App\Domain\Factory;

use App\Domain\DTO\Interfaces\TrickDTOInterface;
use App\Domain\DTO\TrickDTO;
use App\Domain\Entity\Trick;
use App\Domain\Factory\Interfaces\ImageDTOFactoryInterface;
use App\Domain\Factory\Interfaces\TrickDTOFactoryInterface;
use App\Domain\Factory\Interfaces\VideoDTOFactoryInterface;

final class TrickDTOFactory implements TrickDTOFactoryInterface
{

    /**
     * @var ImageDTOFactoryInterface
     */
    private $imageDTOFactory;
    /**
     * @var VideoDTOFactoryInterface
     */
    private $videoDTOFactory;

    /**
     * TrickDTOFactory constructor.
     * @inheritdoc
     */
    public function __construct(
        ImageDTOFactoryInterface $imageDTOFactory,
        VideoDTOFactoryInterface $videoDTOFactory
    ) {
        $this->imageDTOFactory = $imageDTOFactory;
        $this->videoDTOFactory = $videoDTOFactory;
    }

    /**
     * @inheritdoc
     */
    public function create(Trick $trick): TrickDTOInterface
    {
        $imageFeaturedDTO = $this->imageDTOFactory->create($trick->getImageFeatured());

        $images = $trick->getImages()->toArray();
        $imagesDTO = [];
        foreach ($images as $image) {
            $imagesDTO[] = $this->imageDTOFactory->create($image);
        }

        $videos = $trick->getVideos()->toArray();
        $videosDTO = [];
        foreach ($videos as $video) {
            $videosDTO[] = $this->videoDTOFactory->create($video);
        }

        return new TrickDTO(
            $trick->getName(),
            $trick->getDescription(),
            $imageFeaturedDTO,
            $imagesDTO,
            $videosDTO,
            $trick->getCategories()
        );
    }
}
