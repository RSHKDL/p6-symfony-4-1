<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Table(name="app_images")
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @var boolean $isFeatured
     * @ORM\Column(type="boolean", name="is_featured")
     */
    private $isFeatured = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Figure", inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $figure;

    /**
     * @var UploadedFile|null $file
     * @Assert\Image(
     *     maxSize = "500k",
     *     allowPortrait = false,
     *     allowPortraitMessage = "Landscape orientation only",
     *     allowSquare = false,
     *     allowSquareMessage = "Landscape orientation only",
     * )
     */
    private $file;

    private $oldFile;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isFeatured(): bool
    {
        return $this->isFeatured;
    }

    /**
     * @param bool $isFeatured
     */
    public function setIsFeatured(bool $isFeatured): void
    {
        $this->isFeatured = $isFeatured;
    }

    /**
     *
     */
    public function getFigure(): ?Figure
    {
        return $this->figure;
    }

    /*
     *
     */
    public function setFigure(?Figure $figure): self
    {
        $this->figure = $figure;
        return $this;
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile($file = null)
    {
        $this->file = $file;

        if (isset($this->name)) {
            $this->oldFile = $this->name;
            $this->name = null;
        }
    }

    /**
     * @return mixed
     */
    public function getOldFile()
    {
        return $this->oldFile;
    }

    public function getWebPath()
    {
        return "uploads/images/".$this->name;
    }
}
