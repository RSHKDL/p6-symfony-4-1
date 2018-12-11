<?php

namespace App\EventSubscriber;

use App\CollectionManager\Interfaces\CollectionComparatorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class UpdateTrickSubscriber implements EventSubscriberInterface
{
    /**
     * @var CollectionComparatorInterface
     */
    private $collectionComparator;

    /**
     * UpdateTrickSubscriber constructor.
     * @param CollectionComparatorInterface $collectionComparator
     */
    public function __construct(CollectionComparatorInterface $collectionComparator)
    {
        $this->collectionComparator = $collectionComparator;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SUBMIT => 'preSubmit'
        ];
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $imagesDTO = $event->getForm()->get('images')->getData();

        foreach ($imagesDTO as $key => $imageDTO) {
            if (array_key_exists($key, $data['images']) && $data['images'][$key]['file'] === null) {
                $data['images'][$key]['file'] = $imagesDTO[$key]->file;
            }
        }

        if (array_key_exists('images', $data)) {
            foreach ($data['images'] as $key => $dataImage) {
                if ($dataImage['file'] === null) {
                    unset($data['images'][$key]);
                }
            }
        }

        $event->setData($data);
    }
}
