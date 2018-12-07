<?php

namespace App\DTO;

use App\DTO\Interfaces\CategoryDTOInterface;

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
