<?php

namespace App\Factory\Interfaces;

use App\DTO\Interfaces\ImageDTOInterface;
use App\Entity\Image;

interface ImageDTOFactoryInterface
{
    /**
     * @param Image $image
     * @return ImageDTOInterface
     */
    public function create(Image $image): ImageDTOInterface;
}
