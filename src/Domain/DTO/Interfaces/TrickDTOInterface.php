<?php

namespace App\Domain\DTO\Interfaces;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

interface TrickDTOInterface
{
    /**
     * TrickDTOInterface constructor.
     * @param string $name
     * @param string $description
     * @param ImageDTOInterface $imageFeatured
     * @param array|null $images
     * @param array|null $videos
     * @param ArrayCollection|PersistentCollection|null $categories
     */
    public function __construct(
        string $name,
        string $description,
        ImageDTOInterface $imageFeatured,
        ?array $images = null,
        ?array $videos = null,
        $categories
    );
}
