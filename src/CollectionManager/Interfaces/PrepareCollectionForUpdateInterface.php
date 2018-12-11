<?php

namespace App\CollectionManager\Interfaces;

use App\Builder\Interfaces\ImageBuilderInterface;
use App\Builder\Interfaces\VideoBuilderInterface;
use App\Service\Interfaces\FileRemoverInterface;

interface PrepareCollectionForUpdateInterface
{
    /**
     * PrepareCollectionForUpdateInterface constructor.
     * @param ImageBuilderInterface $imageBuilder
     * @param VideoBuilderInterface $videoBuilder
     * @param FileRemoverInterface $fileRemover
     * @param CollectionComparatorInterface $collectionComparator
     */
    public function __construct(
        ImageBuilderInterface $imageBuilder,
        VideoBuilderInterface $videoBuilder,
        FileRemoverInterface $fileRemover,
        CollectionComparatorInterface $collectionComparator
    );

    /**
     * @param array $collection
     * @param array $collectionDTO
     * @return array
     */
    public function prepare(array $collection, array $collectionDTO): array;
}
