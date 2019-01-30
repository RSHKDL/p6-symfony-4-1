<?php

namespace App\Domain\Factory\Interfaces;

use App\Domain\DTO\Interfaces\TrickDTOInterface;
use App\Domain\Entity\Trick;

interface TrickDTOFactoryInterface
{

    /**
     * @param Trick $trick
     * @return TrickDTOInterface
     */
    public function create(Trick $trick): TrickDTOInterface;
}
