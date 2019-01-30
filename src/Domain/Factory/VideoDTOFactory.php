<?php

namespace App\Domain\Factory;

use App\Domain\DTO\Interfaces\VideoDTOInterface;
use App\Domain\DTO\VideoDTO;
use App\Domain\Entity\Video;
use App\Domain\Factory\Interfaces\VideoDTOFactoryInterface;

final class VideoDTOFactory implements VideoDTOFactoryInterface
{

    /**
     * @inheritdoc
     */
    public function create(Video $video): VideoDTOInterface
    {
        return new VideoDTO($video->getRawUrl());
    }
}
