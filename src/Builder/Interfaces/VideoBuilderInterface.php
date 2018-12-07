<?php

namespace App\Builder\Interfaces;

use App\DTO\Interfaces\VideoDTOInterface;
use App\Entity\Video;

interface VideoBuilderInterface
{

    /**
     * @param $videosDTO
     * @param bool $isCollection
     * @return @return Video|array|mixed
     */
    public function build($videosDTO, bool $isCollection);

    /**
     * @param VideoDTOInterface $videoDTO
     * @return Video
     */
    public function createEntity(VideoDTOInterface $videoDTO): Video;
}
