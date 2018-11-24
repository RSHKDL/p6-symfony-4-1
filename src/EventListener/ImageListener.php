<?php

namespace App\EventListener;

use App\Entity\Image;
use App\Service\FileUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageListener
{

    private $uploader;

    /*
     * @var array
     */
    private $filesToRemove = [];

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Image) {
            return;
        }

        $this->uploadImage($entity);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Image) {
            return;
        }

        $this->uploadImage($entity);

        if ($entity->getOldFile()) {
            $this->filesToRemove[] = $this->uploader->getTargetDirectory().'/'.$entity->getOldFile();
        }
    }

    public function postUpdate()
    {

        foreach ($this->filesToRemove as $file) {
            $this->removeImage($file);
        }
        $this->filesToRemove = [];
    }

    public function preRemove(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        if (!$entity instanceof Image) {
            return;
        }

        $this->filesToRemove[] = $this->uploader->getTargetDirectory().'/'.$entity->getName();
    }

    public function postRemove() {

        foreach ($this->filesToRemove as $file) {
            $this->removeImage($file);
        }
        $this->filesToRemove = [];
    }

    private function uploadImage($entity)
    {
        if (!$entity instanceof Image) {
            return;
        }

        $file = $entity->getFile();

        if ($file === null) {
            return;
        }

        // only upload new files
        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
            $entity->setName($fileName);
        }
    }

    private function removeImage($file) {
        if (file_exists($file))
        {
            unlink($file);
        }
    }
}
