<?php

namespace App\Domain\Builder\Interfaces;

use App\Domain\DTO\Interfaces\VideoDTOInterface;
use App\Domain\Entity\Video;

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
