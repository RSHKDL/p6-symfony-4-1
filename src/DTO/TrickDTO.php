<?php

namespace App\DTO;

use App\DTO\Interfaces\ImageDTOInterface;
use App\DTO\Interfaces\TrickDTOInterface;
use Doctrine\Common\Collections\ArrayCollection;

final class TrickDTO implements TrickDTOInterface
{
    /**
     * @var string|null
     */
    public $name;

    /**
     * @var string|null
     */
    public $description;

    /**
     * @var ImageDTOInterface|null
     */
    public $imageFeatured;

    /**
     * @var array|null
     */
    public $images;

    /**
     * @var array|null
     */
    public $videos;

    /**
     * @var ArrayCollection|null
     */
    public $categories;

    /**
     * TrickDTO constructor.
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
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->imageFeatured = $imageFeatured;
        $this->images = $images;
        $this->videos = $videos;
        $this->categories = $categories;
    }
}
