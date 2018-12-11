<?php

namespace App\Factory;

use App\DTO\ImageDTO;
use App\DTO\Interfaces\ImageDTOInterface;
use App\Entity\Image;
use App\Factory\Interfaces\ImageDTOFactoryInterface;
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
