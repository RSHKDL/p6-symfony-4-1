<?php

namespace App\Factory\Interfaces;

use App\DTO\Interfaces\VideoDTOInterface;
use App\Entity\Video;

interface VideoDTOFactoryInterface
{
    /**
     * @param Video $video
     * @return VideoDTOInterface
     */
    public function create(Video $video): VideoDTOInterface;
}
