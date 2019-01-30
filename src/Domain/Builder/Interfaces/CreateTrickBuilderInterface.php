<?php

namespace App\Domain\Builder\Interfaces;

use App\Domain\DTO\Interfaces\TrickDTOInterface;

interface CreateTrickBuilderInterface
{
    /**
     * @param TrickDTOInterface $trickDTO
     * @return mixed
     */
    public function build(TrickDTOInterface $trickDTO);
}
