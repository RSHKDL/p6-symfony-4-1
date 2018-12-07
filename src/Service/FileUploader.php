<?php

namespace App\Service;

use App\Service\Interfaces\FileUploaderInterface;

final class FileUploader implements FileUploaderInterface
{
    /**
     * @var string
     */
    private $publicDirectory;

    /**
     * @var array
     */
    private $filesToUpload = [];

    /**
     * FileUploader constructor.
     * @inheritdoc
     */
    public function __construct(string $publicDirectory)
    {
        $this->publicDirectory = $publicDirectory;
    }

    /**
     * @inheritdoc
     */
    public function addFileToUpload(\SplFileInfo $fileInfo, string $filename, string $path):void
    {
        $this->filesToUpload[] = [
            'file' => $fileInfo,
            'filename' => $filename,
            'path' => $path
        ];
    }

    /**
     * @inheritdoc
     */
    public function uploadFiles():void
    {
        foreach ($this->filesToUpload as $fileToUpload) {
            $directory = $this->getTargetDirectory().$fileToUpload['path'];
            $fileToUpload['file']->move($directory, $fileToUpload['filename']);
        }
    }

    private function getTargetDirectory()
    {
        return $this->publicDirectory;
    }
}
