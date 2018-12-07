<?php

namespace App\Builder;

use App\Builder\Interfaces\VideoBuilderInterface;
use App\DTO\Interfaces\VideoDTOInterface;
use App\Entity\Video;

final class VideoBuilder implements VideoBuilderInterface
{
    /**
     * @inheritdoc
     *
     */
    public function build($videosDTO, bool $isCollection)
    {
        if ($isCollection) {
            $videos = [];
            foreach ($videosDTO as $videoDTO) {
                $videos[] = $this->createEntity($videoDTO);
            }
            return $videos;
        }
        return $this->createEntity($videosDTO);
    }

    /**
     * @inheritdoc
     */
    public function createEntity(VideoDTOInterface $videoDTO): Video
    {
        return new Video($videoDTO->url);
    }
}
