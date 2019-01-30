<?php

namespace App\Domain\Factory\Interfaces;

use App\Domain\DTO\Interfaces\ImageDTOInterface;
use App\Domain\Entity\Image;

interface ImageDTOFactoryInterface
{
    /**
     * @param Image $image
     * @return ImageDTOInterface
     */
    public function create(Image $image): ImageDTOInterface;
}
