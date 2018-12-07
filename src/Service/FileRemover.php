<?php

namespace App\Service;

use App\Entity\Image;
use App\Service\Interfaces\FileRemoverInterface;
use Symfony\Component\Filesystem\Filesystem;

final class FileRemover implements FileRemoverInterface
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
    private $directoryPath;

    /**
     * @var array
     */
    private $filesToRemove = [];

    /**
     * @inheritdoc
     */
    public function __construct(
        Filesystem $filesystem,
        string $publicDirectory
    ) {
        $this->filesystem = $filesystem;
        $this->publicDirectory = $publicDirectory;
    }

    /**
     * @inheritdoc
     */
    public function getDirectory(string $path): void
    {
        $this->directoryPath = $this->publicDirectory . $path;
    }

    /**
     * @inheritdoc
     */
    public function addFileToRemove(Image $image): void
    {
        if (isset($this->directoryPath)) {
            $this->filesToRemove[] = $this->directoryPath.'/'.$image->getName();
        } else {
            $this->filesToRemove[] = $this->publicDirectory.$image->getWebPath();
        }
    }
    /**
     * @inheritdoc
     */
    public function removeFiles(): void
    {
        $this->filesystem->remove($this->filesToRemove);
    }
}
