<?php

namespace App\Domain\Factory;

use App\Domain\DTO\ImageDTO;
use App\Domain\DTO\Interfaces\ImageDTOInterface;
use App\Domain\Entity\Image;
use App\Domain\Factory\Interfaces\ImageDTOFactoryInterface;
use Symfony\Component\HttpFoundation\File\File;

final class ImageDTOFactory implements ImageDTOFactoryInterface
{
    /**
     * @inheritdoc
     */
    public function create(Image $image): ImageDTOInterface
    {
        return new ImageDTO(new File('.'.$image->getWebPath(), false));
    }
}
