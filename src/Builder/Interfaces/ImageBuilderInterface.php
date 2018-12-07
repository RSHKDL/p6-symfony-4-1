<?php

namespace App\Builder\Interfaces;

use App\Service\Interfaces\FileUploaderInterface;
use App\Service\Interfaces\ImageProcessorInterface;

interface ImageBuilderInterface
{

    public function __construct(ImageProcessorInterface $processor, FileUploaderInterface $uploader);

    public function build($imagesDTO, bool $isCollection);
}
