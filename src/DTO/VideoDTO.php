<?php

namespace App\DTO;

use App\DTO\Interfaces\VideoDTOInterface;

final class VideoDTO implements VideoDTOInterface
{
    /**
     * @var string|null
     */
    public $url;

    /**
     * @inheritdoc
     */
    public function __construct(?string $url)
    {
        if ($url) {
            $this->url = $url;
        }
    }

}
