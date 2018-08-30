<?php
/**
 * Created by PhpStorm.
 * User: saysa
 * Date: 30.08.18
 * Time: 13:32
 */

namespace App\EventSubscriber;


use App\Entity\Image;
use App\Event\UploadEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UploadSubscriber implements EventSubscriberInterface
{

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            UploadEvent::name => 'onFileUpload',
        ];
    }

    public function onFileUpload(UploadEvent $event)
    {
        $images = $event->getImages();

        foreach ($images as $image) {
            /**
             * @var $image Image
             */
            $image->setName($image->getFile()->getClientOriginalName());
            $image->setExtension($image->getFile()->guessExtension());
        }
    }
}