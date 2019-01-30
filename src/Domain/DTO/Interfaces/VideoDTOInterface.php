<?php

namespace App\Domain\DTO\Interfaces;

interface VideoDTOInterface
{
    /**
     * VideoDTOInterface constructor.
     * @param string $rawUrl
     */
    public function __construct(string $rawUrl);
}
