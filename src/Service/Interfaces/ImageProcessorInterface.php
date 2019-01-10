<?php

namespace App\Service\Interfaces;

use Symfony\Component\Filesystem\Filesystem;

interface ImageProcessorInterface
{

    /**
     * ImageProcessorInterface constructor.
     * @param SlugMakerInterface $slugMaker
     * @param Filesystem $filesystem
     * @param string $publicDirectory
     * @param string $tricksDirectory
     * @param string $usersDirectory
     */
    public function __construct(
        SlugMakerInterface $slugMaker,
        Filesystem $filesystem,
        string $publicDirectory,
        string $tricksDirectory,
        string $usersDirectory
    );

    /**
     * @param string $context
     * @param string $name
     * @return mixed
     */
    public function initialize(string $context, string $name);

    /**
     * @param \splFileInfo $fileInfo
     * @return array
     */
    public function generateImageInfo(\splFileInfo $fileInfo): array;

    /**
     * @return array
     */
    public function getUpdateImageInfo(): array;
}
