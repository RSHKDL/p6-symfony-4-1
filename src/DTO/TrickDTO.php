<?php

namespace App\DTO;

use App\DTO\Interfaces\ImageDTOInterface;
use App\DTO\Interfaces\TrickDTOInterface;
use App\Service\SlugMaker;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

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
