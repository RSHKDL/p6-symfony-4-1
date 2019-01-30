<?php

namespace App\Domain\DTO;

use App\Domain\DTO\Interfaces\VideoDTOInterface;

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
