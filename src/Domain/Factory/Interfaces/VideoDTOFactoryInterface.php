<?php

namespace App\Domain\Factory\Interfaces;

use App\Domain\DTO\Interfaces\VideoDTOInterface;
use App\Domain\Entity\Video;

interface VideoDTOFactoryInterface
{
    /**
     * @param Video $video
     * @return VideoDTOInterface
     */
    public function create(Video $video): VideoDTOInterface;
}
