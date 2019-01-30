<?php

namespace App\Domain\DTO;

use App\Domain\DTO\Interfaces\ImageDTOInterface;

final class ImageDTO implements ImageDTOInterface
{
    /**
     * @var \SplFileInfo $file
     */
    public $file;

    /**
     * ImageDTOInterface constructor.
     *
     * Use the php SplFileInfo Class : http://php.net/manual/en/class.splfileinfo.php
     * @param \SplFileInfo|null $file
     */
    public function __construct(?\SplFileInfo $file = null)
    {
        $this->file = $file;
    }
}
