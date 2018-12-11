<?php

namespace App\CollectionManager\Interfaces;

interface CollectionComparatorInterface
{
    /**
     * @param array $collection
     * @param array $collectionDTO
     * @param string $className
     */
    public function compare(array $collection, array $collectionDTO, string $className): void;

    /**
     * @return array
     */
    public function getNewObjects(): array;

    /**
     * @return array
     */
    public function getOldObjects(): array;
}
