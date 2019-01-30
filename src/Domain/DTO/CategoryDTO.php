<?php

namespace App\Domain\DTO;

use App\Domain\DTO\Interfaces\CategoryDTOInterface;

final class CategoryDTO implements CategoryDTOInterface
{
    /**
     * @var string
     */
    public $name;

    /**
     * @inheritdoc
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
