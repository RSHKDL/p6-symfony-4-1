<?php

namespace App\Service;

use App\Service\Interfaces\DirectoryModifierInterface;
use Symfony\Component\Filesystem\Filesystem;

final class DirectoryModifier implements DirectoryModifierInterface
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
     * @var array
     */
    private $modifyDirectory;

    public function __construct(
        Filesystem $filesystem,
        string $publicDirectory
    )
    {
        $this->filesystem = $filesystem;
        $this->publicDirectory = $publicDirectory;
    }

    /**
     * @inheritdoc
     */
    public function getDirectoryToModify(string $oldPath, string $newPath): void
    {
        $this->modifyDirectory = [
            'oldPath' => $this->publicDirectory . $oldPath,
            'newPath' => $this->publicDirectory . $newPath
        ];
    }

    /**
     * @inheritdoc
     */
    public function moveFilesToDirectory(): void
    {
        if ($this->modifyDirectory) {
            $oldPath = $this->modifyDirectory['oldPath'];
            $newPath = $this->modifyDirectory['newPath'];

            $this->filesystem->mkdir($newPath);
            $files = scandir($oldPath);
            foreach ($files as $file) {
                if (!in_array($file, ['.', '..'])) {
                    $filePath = $oldPath.'/'.$file;
                    $this->filesystem->copy($filePath, $newPath.'/'.$file);
                    $this->filesystem->remove($filePath);
                }
            }
            $this->filesystem->remove($oldPath);
        }
    }
}
