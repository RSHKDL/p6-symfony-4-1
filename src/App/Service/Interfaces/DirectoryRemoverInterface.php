<?php

namespace App\App\Service\Interfaces;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Interface DirectoryRemoverInterface
 * @package App\App\Service\Interfaces
 */
interface DirectoryRemoverInterface
{

    /**
     * DirectoryRemoverInterface constructor.
     * @param Filesystem $filesystem
     * @param string $publicDirectory
     */
    public function __construct(Filesystem $filesystem, string $publicDirectory);

    /**
     * @param string $path
     */
    public function removeDirectory(string $path): void;
}
