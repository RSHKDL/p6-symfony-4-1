<?php

namespace App\Domain\CollectionManager\Interfaces;

use App\Domain\Builder\Interfaces\ImageBuilderInterface;
use App\Domain\Builder\Interfaces\VideoBuilderInterface;
use App\App\Service\Interfaces\FileRemoverInterface;

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
