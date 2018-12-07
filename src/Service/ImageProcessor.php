<?php

namespace App\Service;

use App\Service\Interfaces\ImageProcessorInterface;
use Symfony\Component\Filesystem\Filesystem;

final class ImageProcessor implements ImageProcessorInterface
{
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
        Filesystem $filesystem,
        string $publicDirectory,
        string $tricksDirectory,
        string $usersDirectory
    ) {

        $this->filesystem = $filesystem;
        $this->publicDirectory = $publicDirectory;
        $this->tricksDirectory = $tricksDirectory;
        $this->usersDirectory = $usersDirectory;
    }

    /**
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
        $this->path = $directory . '/' . strtolower(str_replace(' ', '_', $name));
        $this->alt = 'image-' . strtolower(str_replace(' ', '-', $name));
        $this->filesystem->mkdir($this->publicDirectory.$this->path);
    }

    /**
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

    public function getUpdateImageInfo(): array
    {
        return [

        ];
    }

}
