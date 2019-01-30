<?php

namespace App\Domain\DTO\Interfaces;


interface ImageDTOInterface
{
    /**
     * ImageDTOInterface constructor.
     *
     * Use the php SplFileInfo Class : http://php.net/manual/en/class.splfileinfo.php
     * @param \SplFileInfo|null $file
     */
    public function __construct(?\SplFileInfo $file = null);
}
