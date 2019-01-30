<?php

namespace App\App\Service\Interfaces;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Interface DirectoryModifierInterface
 * @package App\App\Service\Interfaces
 */
interface DirectoryModifierInterface
{
    /**
     * DirectoryModifierInterface constructor.
     * @param Filesystem $filesystem
     * @param string $publicDirectory
     */
    public function __construct(Filesystem $filesystem, string $publicDirectory);

    /**
     * @param string $oldPath
     * @param string $newPath
     */
    public function getDirectoryToModify(string $oldPath, string $newPath): void;

    /**
     *
     */
    public function moveFilesToDirectory(): void;
}
