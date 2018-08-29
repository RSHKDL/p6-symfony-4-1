<?php
namespace App\EventListener;

use App\Entity\Figure;
use App\Service\FileUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FeaturedImageUploadListener
{

    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Figure) {
            return;
        }
        if($filename = $entity->getFeaturedImage()) {
            $entity->setFeaturedImage($filename);
        }
    }

    private function uploadFile($entity)
    {
        // upload only works for Tricks entities
        if (!$entity instanceof Figure) {
            return;
        }

        $file = $entity->getFeaturedImage();

        // only upload new files
        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
            $entity->setFeaturedImage($fileName);
        }
        // prevents the full file path being saved on updates
        // as the path is set on the postLoad listener
        /*elseif ($file instanceof File) {
            $entity->setFeaturedImage($file->getFilename());
        }*/
    }
}
