<?php

namespace App\DTO;

use App\DTO\Interfaces\ImageDTOInterface;
use App\DTO\Interfaces\TrickDTOInterface;
use Doctrine\Common\Collections\ArrayCollection;

final class TrickDTO implements TrickDTOInterface
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var ImageDTOInterface
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
     * @var ArrayCollection
     */
    public $categories;

    /**
     * TrickDTO constructor.
     * @param string $name
     * @param string $description
     * @param ImageDTOInterface $imageFeatured
     * @param array|null $images
     * @param array|null $videos
     * @param ArrayCollection $categories
     */
    public function __construct(
        string $name,
        string $description,
        ImageDTOInterface $imageFeatured,
        array $images = null,
        array $videos = null,
        ArrayCollection $categories
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->imageFeatured = $imageFeatured;
        $this->images = $images;
        $this->videos = $videos;
        $this->categories = $categories;
    }
}
