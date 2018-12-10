<?php

namespace App\DTO\Interfaces;

use Doctrine\Common\Collections\ArrayCollection;

interface TrickDTOInterface
{
    /**
     * TrickDTOInterface constructor.
     * @param string|null $name
     * @param string|null $description
     * @param ImageDTOInterface|null $imageFeatured
     * @param array|null $images
     * @param array|null $videos
     * @param ArrayCollection|null $categories
     */
    public function __construct(
        ?string $name,
        ?string $description,
        ?ImageDTOInterface $imageFeatured,
        ?array $images = null,
        ?array $videos = null,
        ?ArrayCollection $categories
    );
}
