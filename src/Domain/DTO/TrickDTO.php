<?php

namespace App\Domain\DTO;

use App\Domain\DTO\Interfaces\ImageDTOInterface;
use App\Domain\DTO\Interfaces\TrickDTOInterface;
use Doctrine\Common\Collections\ArrayCollection;

final class TrickDTO implements TrickDTOInterface
{
    /**
     * @var null|string
     */
    public $name;

    /**
     * @var null|string
     */
    public $description;

    /**
     * @var null|ImageDTOInterface
     */
    public $imageFeatured;

    /**
     * @var null|array
     */
    public $images;

    /**
     * @var null|array
     */
    public $videos;

    /**
     * @var null|ArrayCollection
     */
    public $categories;

    /**
     * TrickDTO constructor.
     * @inheritdoc
     */
    public function __construct(
        ?string $name,
        ?string $description,
        ?ImageDTOInterface $imageFeatured,
        ?array $images = null,
        ?array $videos = null,
        $categories
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->imageFeatured = $imageFeatured;
        $this->images = $images;
        $this->videos = $videos;
        $this->categories = $categories;
    }
}
