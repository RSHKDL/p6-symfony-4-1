<?php

namespace App\App\Service;

use App\App\Service\Interfaces\ImageProcessorInterface;
use App\App\Service\Interfaces\SlugMakerInterface;
use Symfony\Component\Filesystem\Filesystem;

final class ImageProcessor implements ImageProcessorInterface
{
    /**
     * @var SlugMakerInterface
     */
    private $slugMaker;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var string
     */
    private $publicDirectory;
    /**
     * @var string
     */
    private $tricksDirectory;
    /**
     * @var string
     */
    private $usersDirectory;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $alt;

    /**
     * ImageProcessor constructor.
     * @inheritdoc
     */
    public function __construct(
        SlugMakerInterface $slugMaker,
        Filesystem $filesystem,
        string $publicDirectory,
        string $tricksDirectory,
        string $usersDirectory
    ) {
        $this->slugMaker = $slugMaker;
        $this->filesystem = $filesystem;
        $this->publicDirectory = $publicDirectory;
        $this->tricksDirectory = $tricksDirectory;
        $this->usersDirectory = $usersDirectory;
    }

    /**
     * Initialize the "processor" depending on context (trick or user entity).
     * Define the attributes used later by an Image entity (path and alt),
     * then create the directory where the images will be stored.
     *
     * @inheritdoc
     */
    public function initialize(string $context, string $name)
    {
        switch ($context) {
            case 'trick':
                $directory = $this->tricksDirectory;
                break;
            case 'user':
                $directory = $this->usersDirectory;
                break;
        }
        $this->name = $name;
        $this->path = $directory . '/' . $this->slugMaker->slugify($name, false);
        $this->alt = 'image-' . $this->slugMaker->slugify($name, true);
        $this->filesystem->mkdir($this->publicDirectory.$this->path);
    }

    /**
     * Generate Image entity attributes
     *
     * @inheritdoc
     */
    public function generateImageInfo(\splFileInfo $fileInfo): array
    {
        return [
            'filename'  => md5(uniqid()).'.'.$fileInfo->guessExtension(),
            'path'      => $this->path,
            'alt'       => $this->alt
        ];
    }

    /**
     * @inheritdoc
     */
    public function getUpdateImageInfo(): array
    {
        return [
            'path'  => $this->path,
            'alt'   => $this->alt
        ];
    }
}
