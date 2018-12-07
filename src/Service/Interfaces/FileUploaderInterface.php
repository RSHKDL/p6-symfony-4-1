<?php

namespace App\Service\Interfaces;

interface FileUploaderInterface
{

    /**
     * FileUploaderInterface constructor.
     * @param string $publicDirectory
     */
    public function __construct(string $publicDirectory);

    /**
     * @param \SplFileInfo $fileInfo
     * @param string $filename
     * @param string $path
     */
    public function addFileToUpload(\SplFileInfo $fileInfo, string $filename, string $path): void;

    public function uploadFiles(): void;
}
