<?php
namespace App\EventListener;

use App\Entity\Figure;
use App\Entity\Image;
use App\Service\FileUploader;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class ImageUploadListener
{
    /*
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Image) {
            return;
        }
    }
    */
}
