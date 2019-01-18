<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Table(name="app_images")
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $alt;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $path;

    /**
     * @var UploadedFile|null $file
     */
    private $file;

    private $oldFile;

    public function __construct(
        string $name,
        string $path,
        string $alt
    ) {
        $this->name = $name;
        $this->path = $path;
        $this->alt = $alt;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAlt(): string
    {
        return $this->alt;
    }

    /**
     * @param string $alt
     */
    public function setAlt(string $alt)
    {
        $this->alt = $alt;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->path = $path;
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
     * @return string
     */
    public function getWebPath()
    {
        return $this->path.'/'.$this->name;
    }
}
