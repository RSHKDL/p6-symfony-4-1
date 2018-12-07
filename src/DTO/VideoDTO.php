<?php

namespace App\DTO;

use App\DTO\Interfaces\VideoDTOInterface;

final class VideoDTO implements VideoDTOInterface
{
    /**
     * @var string
     */
    public $url;

    /**
     * @inheritdoc
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

}
