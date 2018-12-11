<?php

namespace App\Factory;

use App\DTO\Interfaces\TrickDTOInterface;
use App\DTO\TrickDTO;
use App\Entity\Trick;
use App\Factory\Interfaces\ImageDTOFactoryInterface;
use App\Factory\Interfaces\TrickDTOFactoryInterface;
use App\Factory\Interfaces\VideoDTOFactoryInterface;

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
