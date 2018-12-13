<?php

namespace App\DTO;

use App\DTO\Interfaces\VideoDTOInterface;

final class VideoDTO implements VideoDTOInterface
{
    /**
     * @var string $rawUrl
     */
    public $rawUrl;

    /**
     * @inheritdoc
     */
    public function __construct(string $rawUrl)
    {
        $this->rawUrl = $rawUrl;
    }
}
