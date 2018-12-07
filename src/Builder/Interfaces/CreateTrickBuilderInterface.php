<?php

namespace App\Builder\Interfaces;

use App\DTO\Interfaces\TrickDTOInterface;

interface CreateTrickBuilderInterface
{
    /**
     * @param TrickDTOInterface $trickDTO
     * @return mixed
     */
    public function build(TrickDTOInterface $trickDTO);
}
