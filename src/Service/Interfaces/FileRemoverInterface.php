<?php

namespace App\Service\Interfaces;

use App\Entity\Image;
use Symfony\Component\Filesystem\Filesystem;

interface FileRemoverInterface
{

    /**
     * FileRemoverInterface constructor.
     * @param Filesystem $filesystem
     * @param string $publicDirectory
     */
    public function __construct(Filesystem $filesystem, string $publicDirectory);

    /**
     * Get the directory to remove
     * @param string $path
     */
    public function getDirectory(string $path): void;

    /**
     * Add the files to remove in an array
     * @param Image $image
     */
    public function addFileToRemove(Image $image): void;

    /**
     * Remove the files
     */
    public function removeFiles(): void;
}
