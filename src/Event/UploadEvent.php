<?php
/**
 * Created by PhpStorm.
 * User: saysa
 * Date: 30.08.18
 * Time: 13:34
 */

namespace App\Event;


use Doctrine\ORM\PersistentCollection;
use Symfony\Component\EventDispatcher\Event;

class UploadEvent extends Event
{
    const name = 'file.upload';

    protected $images = null;

    public function __construct(PersistentCollection $images)
    {
        $this->images = $images;
    }

    public function getImages()
    {
        return $this->images;
    }
}