<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
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
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $extension;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Figure", inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $figure;

    /* @var UploadedFile $file */
    private $file;

    private $tempFilename;

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
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension($extension): void
    {
        $this->extension = $extension;
    }

    public function getFigure(): ?Figure
    {
        return $this->figure;
    }

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
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        if (null !== $this->name) {
            $this->tempFilename = $this->name;
            $this->name = null;
            $this->extension = null;
        }
    }

    /**
     * If no file is set, do nothing,
     * Else store the file extension and original name
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null === $this->file)
        {
            return;
        }

        $this->setName($this->file->getClientOriginalName());
        $this->setExtension($this->file->guessExtension());
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // If no file is set, do nothing
        if (null === $this->file)
        {
            return;
        }

        // A file is present, remove it
        if (null !== $this->tempFilename)
        {
            $oldFile = $this->getUploadDirectory()."image-".$this->id.".".$this->extension;
            if (file_exists($oldFile))
            {
                unlink($oldFile);
            }
        }

        $figureId = $this->getFigure()->getId();
        // Move the file to the upload folder
        $this->file->move(
            $this->getUploadDirectory(),
            "image-".$this->id."-figure-".$figureId.".".$this->extension
        );
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        // Save the name of the file we would want to remove
        $figureId = $this->getFigure()->getId();
        $this->tempFilename = $this->getUploadDirectory()."image-".$this->id."-figure-".$figureId.".".$this->extension;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        // PostRemove => We no longer have the entity's ID => Use the name we saved
        if (file_exists($this->tempFilename))
        {
            // Remove file
            unlink($this->tempFilename);
        }
    }

    public function getUploadDirectory()
    {
        return 'uploads/tests';
    }

    public function getWebPath()
    {
        $figureId = $this->getFigure()->getId();
        return $this->getUploadDirectory()."/image-".$this->id."-figure-".$figureId.".".$this->extension;
    }
}
