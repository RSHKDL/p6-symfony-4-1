<?php

namespace App\Factory;

use App\DTO\Interfaces\VideoDTOInterface;
use App\DTO\VideoDTO;
use App\Entity\Video;
use App\Factory\Interfaces\VideoDTOFactoryInterface;

final class VideoDTOFactory implements VideoDTOFactoryInterface
{

    /**
     * @inheritdoc
     */
    public function create(Video $video): VideoDTOInterface
    {
        return new VideoDTO(null);
    }
}
