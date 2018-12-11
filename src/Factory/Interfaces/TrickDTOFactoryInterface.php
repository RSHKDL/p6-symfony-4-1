<?php

namespace App\Factory\Interfaces;

use App\DTO\Interfaces\TrickDTOInterface;
use App\Entity\Trick;

interface TrickDTOFactoryInterface
{

    /**
     * @param Trick $trick
     * @return TrickDTOInterface
     */
    public function create(Trick $trick): TrickDTOInterface;
}
