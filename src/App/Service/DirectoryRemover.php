<?php

namespace App\App\Service;

use App\App\Service\Interfaces\DirectoryRemoverInterface;
use Symfony\Component\Filesystem\Filesystem;

final class DirectoryRemover implements DirectoryRemoverInterface
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
     * DirectoryRemover constructor.
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
    public function removeDirectory(string $path): void
    {
        $this->filesystem->remove($this->publicDirectory.$path);
    }
}
