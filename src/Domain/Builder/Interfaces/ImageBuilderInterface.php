<?php

namespace App\Domain\Builder\Interfaces;

use App\App\Service\Interfaces\FileUploaderInterface;
use App\App\Service\Interfaces\ImageProcessorInterface;

interface ImageBuilderInterface
{

    public function __construct(ImageProcessorInterface $processor, FileUploaderInterface $uploader);

    public function build($imagesDTO, bool $isCollection);
}
